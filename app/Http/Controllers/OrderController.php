<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
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
            'coupon_key' => 'nullable|string|exists:coupons,coupon_key',
            'required' => 'nullable|string' // Nếu cần nhập yêu cầu
        ]);

        $customer = Auth::guard('customer')->user();
        $productVariant = ProductVariant::findOrFail($request->product_variant_id);

        if ($productVariant->product->customer_id == $customer->id) {
            return response()->json(['error' => 'Bạn không thể mua gian hàng của mình!'], 403);
        }

        $total = $productVariant->price * $request->quantity;
        $coupon = null;
        $discountAmount = 0;

        // Kiểm tra mã giảm giá
        if ($request->coupon_key) {
            $coupon = Coupon::where('coupon_key', $request->coupon_key)
                ->where('status', 'active')
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->first();

            if (!$coupon) {
                return response()->json(['error' => 'Mã giảm giá không hợp lệ hoặc đã hết hạn!'], 403);
            }

            if ($coupon->type === 'percent') {
                $discountAmount = min(($total * $coupon->percent) / 100, $coupon->max_amount);
            } else {
                $discountAmount = $coupon->max_amount;
            }

            $total -= $discountAmount;
        }

        if ($customer->Balance < $total) {
            return response()->json(['error' => 'Số dư không đủ để thanh toán đơn hàng!'], 403);
        }

        // Xử lý trường hợp `type = null`, yêu cầu nhập required
        if (is_null($productVariant->type)) {
            if (!$request->required) {
                return response()->json(['error' => 'Vui lòng nhập yêu cầu trước khi đặt hàng!'], 400);
            }
        }

        // Tạo đơn hàng
        $order = Order::create([
            'customer_id' => $customer->id,
            'product_variant_id' => $productVariant->id,
            'quantity' => $request->quantity,
            'total' => $total,
            'status' => 'pending',
            'coupon_id' => $coupon ? $coupon->id : null,
            'required' => $request->required ?? null
        ]);

        // Trừ số dư tài khoản khách hàng
        $customer->Balance -= $total;
        $customer->save();

        // Lưu `OrderDetail` nếu là `Tài khoản` hoặc `Email`
        if ($productVariant->type === "Tài khoản") {
            $stocks = $productVariant->stocks->flatMap->uidFacebooks->take($request->quantity);
        } elseif ($productVariant->type === "Email") {
            $stocks = $productVariant->stocks->flatMap->uidEmails->take($request->quantity);
        } else {
            $stocks = collect(); // Không tạo `OrderDetail`
        }

        foreach ($stocks as $stock) {
            OrderDetail::create([
                'order_id' => $order->id,
                'account' => $stock->uid,
                'value' => $stock->value,
                'status' => 'success'
            ]);
        }

        return response()->json(['success' => 'Đơn hàng đã được tạo!', 'order' => $order]);
    }


}
