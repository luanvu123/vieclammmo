<?php
namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'content' => 'required|string|max:1000',
        ]);

        Complaint::create([
            'customer_id' => Auth::guard('customer')->id(),
            'order_id' => $request->order_id,
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'Gửi khiếu nại thành công.');
    }
}

