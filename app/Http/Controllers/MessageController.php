<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{


 public function create($customerId)
{
    $receiver = Customer::findOrFail($customerId);
    $isOnline = $receiver->last_active_at && $receiver->last_active_at->diffInHours(now()) <= 8;
    $lastActiveTime = $isOnline ? $receiver->last_active_at->diffInHours(now()) . ' giờ trước' : null;

    // Cập nhật trạng thái is_read = true cho tất cả tin nhắn chưa đọc từ customerId
    Message::where('sender_id', $customerId)
        ->where('receiver_id', Auth::guard('customer')->id())
        ->where('is_read', false)
        ->update(['is_read' => true]);

    // Lấy danh sách người đã từng nhắn tin, sắp xếp theo tin nhắn mới nhất
    $conversations = Message::where('sender_id', Auth::guard('customer')->id())
        ->orWhere('receiver_id', Auth::guard('customer')->id())
        ->with(['sender', 'receiver'])
        ->orderByDesc('created_at')
        ->get()
        ->groupBy(function ($message) {
            return $message->sender_id == Auth::guard('customer')->id() ? $message->receiver_id : $message->sender_id;
        });

    return view('messages.create', compact('receiver', 'isOnline', 'lastActiveTime', 'conversations'));
}


   public function store(Request $request, $receiverId)
{
    $request->validate([
        'message' => 'required|string',
        'attachment' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf,doc,docx,xlsx|max:2048',
    ]);

    $message = new Message();
    $message->sender_id = Auth::guard('customer')->id();
    $message->receiver_id = $receiverId;
    $message->message = $request->message;

    // Nếu có file đính kèm
    if ($request->hasFile('attachment')) {
        $file = $request->file('attachment');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('attachments', $filename, 'public');
        $message->attachment = $path;
    }

    $message->save();

    return redirect()->back()->with('success', 'Tin nhắn đã được gửi.');
}

}
