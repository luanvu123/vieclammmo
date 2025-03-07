<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request)
{
    if (!Auth::guard('customer')->check()) {
        return response()->json(['error' => 'Bạn cần đăng nhập để mua hàng!'], 403);
    }

    $request->validate([
        'product_variant_id' => 'required|exists:product_variants,id',
        'quantity' => 'required|integer|min:1',
    ]);

    $customer = Auth::guard('customer')->user();
    $productVariant = ProductVariant::findOrFail($request->product_variant_id);

    // Kiểm tra nếu khách hàng mua sản phẩm của chính mình
    if ($productVariant->product->customer_id == $customer->id) {
        return response()->json(['error' => 'Bạn không thể mua gian hàng của mình!'], 403);
    }

    // Tính tổng giá tiền
    $total = $productVariant->price * $request->quantity;

    // Kiểm tra số dư tài khoản
    if ($customer->Balance < $total) {
        return response()->json(['error' => 'Số dư không đủ để thanh toán đơn hàng!'], 403);
    }

    // Lưu đơn hàng
    $order = Order::create([
        'customer_id' => $customer->id,
        'product_variant_id' => $productVariant->id,
        'quantity' => $request->quantity,
        'total' => $total,
        'status' => 'pending', // Trạng thái mặc định
    ]);

    // Trừ số dư tài khoản
    $customer->Balance -= $total;
    $customer->save();

    return response()->json(['success' => 'Đơn hàng đã được tạo!', 'order' => $order]);
}

}
