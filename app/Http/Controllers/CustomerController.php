<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Message;
use App\Models\Order;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use PragmaRX\Google2FA\Google2FA;



class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['customer', '2fa']);
    }
    public function message()
    {
        $customer = Auth::guard('customer')->user();
        $conversations = Message::where('sender_id', $customer->id)
            ->orWhere('receiver_id', $customer->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique(function ($item) use ($customer) {
                return $item->sender_id == $customer->id ? $item->receiver_id : $item->sender_id;
            });

        return view('message.index', compact('customer', 'conversations'));
    }
    public function loadMessages($userId)
    {
        $customer = Auth::guard('customer')->user();

        $messages = Message::where(function ($query) use ($customer, $userId) {
            $query->where('sender_id', $customer->id)
                ->where('receiver_id', $userId);
        })->orWhere(function ($query) use ($customer, $userId) {
            $query->where('sender_id', $userId)
                ->where('receiver_id', $customer->id);
        })->orderBy('created_at', 'asc')->get();

        // Đánh dấu tin nhắn đã đọc
        Message::where('sender_id', $userId)
            ->where('receiver_id', $customer->id)
            ->where('status', '!=', 'read')
            ->update(['status' => 'read']);

        return view('message.partials.messages', compact('messages', 'customer'));
    }
    public function sendMessage(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        $validated = $request->validate([
            'receiver_id' => 'required|exists:customers,id',
            'message' => 'required_without:attachment',
            'attachment' => 'nullable|file|max:5120', // 5MB max
        ]);

        $message = new Message();
        $message->sender_id = $customer->id;
        $message->receiver_id = $validated['receiver_id'];
        $message->message = $validated['message'] ?? null;

        // Xử lý file đính kèm nếu có
        if ($request->hasFile('attachment')) {
            $attachment = $request->file('attachment');
            $fileName = time() . '_' . $attachment->getClientOriginalName();
            $attachment->storeAs('message_attachments', $fileName, 'public');
            $message->attachment = 'message_attachments/' . $fileName;
        }

        $message->status = 'sent';
        $message->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'customer_name' => $customer->name
            ]);
        }

        return redirect()->back()->with('success', 'Tin nhắn đã được gửi');
    }

    public function dashboard()
    {
        return view('admin_customer.index');
    }
    public function checkout()
    {
        return view('pages.checkout');
    }



    public function profile()
    {
        $customer = Auth::guard('customer')->user();
        // Đếm số sản phẩm đã mua
        // Đếm số sản phẩm đã bán (các sản phẩm có đơn hàng)
        $productsSold = Product::where('customer_id', $customer->id)
            ->whereHas('productVariants.orders')
            ->count();

        // Đếm số gian hàng đã bán (số sản phẩm của khách có ít nhất 1 đơn hàng)
        $storesCount = Product::where('customer_id', $customer->id)
            ->whereHas('productVariants.orders')
            ->distinct()
            ->count();

        // Đếm số gian hàng đã mua (dựa trên số lượng đơn hàng của khách)
        $productsBought = Order::where('customer_id', $customer->id)->count();

        // Đếm số bài viết
        $postsCount = Post::where('customer_id', $customer->id)->count();

        // Kiểm tra trạng thái online
        $isOnline = $customer->last_active_at && $customer->last_active_at->diffInHours(now()) <= 8;
        $lastActiveTime = $isOnline ? $customer->last_active_at->diffInHours(now()) . ' giờ trước' : null;

        $loginHistories = $customer->loginHistories()->orderBy('login_time', 'desc')->take(5)->get();

        return view('pages.profile', compact(
            'customer',
            'loginHistories',
            'productsSold',
            'storesCount',
            'productsBought',
            'postsCount',
            'isOnline',
            'lastActiveTime'
        ));
    }
    public function profileEdit()
    {
        $customer = Auth::guard('customer')->user();
        return view('pages.profile_edit', compact('customer'));
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'url_facebook' => 'nullable|url',
        ]);

        $customer = Auth::guard('customer')->user();
        $customer->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'url_facebook' => $request->url_facebook,
        ]);

        return redirect()->route('profile.site')->with('success', 'Cập nhật hồ sơ thành công.');
    }
    public function editKYC(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        // Kiểm tra và lưu ảnh mặt trước CMND
        if ($request->hasFile('Front_ID_card_image')) {
            $frontImage = $request->file('Front_ID_card_image');
            $frontImageName = time() . '_front.' . $frontImage->getClientOriginalExtension();
            $frontImage->move(public_path('uploads/kyc'), $frontImageName);
            $customer->Front_ID_card_image = 'uploads/kyc/' . $frontImageName;
        }

        // Kiểm tra và lưu ảnh mặt sau CMND
        if ($request->hasFile('Back_ID_card_image')) {
            $backImage = $request->file('Back_ID_card_image');
            $backImageName = time() . '_back.' . $backImage->getClientOriginalExtension();
            $backImage->move(public_path('uploads/kyc'), $backImageName);
            $customer->Back_ID_card_image = 'uploads/kyc/' . $backImageName;
        }

        // Kiểm tra và lưu ảnh chân dung
        if ($request->hasFile('Portrait_image')) {
            $portraitImage = $request->file('Portrait_image');
            $portraitImageName = time() . '_portrait.' . $portraitImage->getClientOriginalExtension();
            $portraitImage->move(public_path('uploads/kyc'), $portraitImageName);
            $customer->Portrait_image = 'uploads/kyc/' . $portraitImageName;
        }

        // Cập nhật isEkyc nếu đã có đủ 3 ảnh
        if ($customer->Front_ID_card_image && $customer->Back_ID_card_image && $customer->Portrait_image) {
            $customer->isEkyc = true;
        }

        $customer->save();

        return redirect()->back()->with('success', 'Đã cập nhật eKYC thành công!');
    }


    // Phương thức tạo secret key cho 2FA
    public function generate2faSecret(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        // Kiểm tra nếu người dùng đã có secret key
        if ($customer->google2fa_secret) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn đã có secret key 2FA',
            ]);
        }

        // Tạo secret key mới
        $google2fa = new Google2FA();
        $secretKey = $google2fa->generateSecretKey();

        // Lưu secret key vào session
        $request->session()->put('2fa_secret', $secretKey);

        // Tạo QR code
        $qrCodeUrl = $google2fa->getQRCodeUrl(
            'TapHoaMmo', // Tên ứng dụng của bạn
            $customer->email, // Email người dùng
            $secretKey // Secret key
        );

        return response()->json([
            'success' => true,
            'secret' => $secretKey,
            'qrCodeUrl' => $qrCodeUrl,
        ]);
    }

    // Phương thức bật 2FA
    public function enable2fa(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        // Validate dữ liệu
        $request->validate([
            'verification_code' => 'required|string|size:6',
        ]);

        // Lấy secret key từ session
        $secretKey = $request->session()->get('2fa_secret');

        if (!$secretKey) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy secret key, vui lòng tạo lại',
            ]);
        }

        // Xác nhận mã OTP
        $google2fa = new Google2FA();
        $valid = $google2fa->verifyKey($secretKey, $request->verification_code);

        if (!$valid) {
            return response()->json([
                'success' => false,
                'message' => 'Mã xác thực không đúng, vui lòng thử lại',
            ]);
        }

        // Cập nhật dữ liệu người dùng
        $customer->google2fa_secret = $secretKey;
        $customer->is2Fa = true;
        $customer->save();

        // Xóa secret key khỏi session
        $request->session()->forget('2fa_secret');

        return response()->json([
            'success' => true,
            'message' => 'Bảo mật 2 lớp đã được bật thành công',
        ]);
    }

    // Phương thức tắt 2FA
    public function disable2fa(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        // Validate dữ liệu
        $request->validate([
            'verification_code' => 'required|string|size:6',
        ]);

        // Xác nhận mã OTP
        $google2fa = new Google2FA();
        $valid = $google2fa->verifyKey($customer->google2fa_secret, $request->verification_code);

        if (!$valid) {
            return response()->json([
                'success' => false,
                'message' => 'Mã xác thực không đúng, vui lòng thử lại',
            ]);
        }

        // Cập nhật dữ liệu người dùng
        $customer->google2fa_secret = null;
        $customer->is2Fa = false;
        $customer->save();

        return response()->json([
            'success' => true,
            'message' => 'Bảo mật 2 lớp đã được tắt thành công',
        ]);
    }
    // Add these methods to your CustomerController class
    public function show2faVerify()
    {
        return view('pages.2fa_verify');
    }

    public function verify2fa(Request $request)
    {
        $request->validate([
            'verification_code' => 'required|string|size:6',
        ]);

        $customer = Auth::guard('customer')->user();
        $google2fa = new Google2FA();

        $valid = $google2fa->verifyKey($customer->google2fa_secret, $request->verification_code);

        if ($valid) {
            $request->session()->put('2fa_verified', true);
            return redirect()->intended(route('profile.site'));
        }

        return back()->withErrors(['verification_code' => 'Mã xác thực không đúng']);
    }
}
