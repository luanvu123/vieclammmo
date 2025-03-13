<?php

namespace App\Http\Controllers;

use App\Jobs\CreateDepositJob;
use App\Models\Coupon;
use App\Models\Deposit;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductVariant;
use App\Models\Review;
use App\Models\Stock;
use App\Models\UidEmail;
use App\Models\UidFacebook;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!Auth::guard('customer')->check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để xem đơn hàng!');
        }

        $customer = Auth::guard('customer')->user();
        $orders = Order::where('customer_id', $customer->id)
            ->with(['productVariant.product', 'orderDetails', 'coupon'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin_customer.orders.index', compact('orders'));
    }

    public function show($order_key)
    {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!Auth::guard('customer')->check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để xem chi tiết đơn hàng!');
        }

        $customer = Auth::guard('customer')->user();
        $order = Order::where('order_key', $order_key)
            ->where('customer_id', $customer->id)
            ->with(['productVariant.product', 'orderDetails', 'coupon'])
            ->firstOrFail();

        $reviews = Review::where('order_id', $order->id)
            ->where('customer_id', $customer->id)
            ->get();

        return view('admin_customer.orders.show', compact('order', 'reviews'));
    }
    public function store(Request $request)
    {
        if (!Auth::guard('customer')->check()) {
            return response()->json(['error' => 'Bạn cần đăng nhập để mua hàng!'], 403);
        }

        $request->validate([
            'product_variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
            'coupon_key' => 'nullable|string|exists:coupons,coupon_key',
            'required' => 'nullable|string'
        ]);

        $customer = Auth::guard('customer')->user();
        $productVariant = ProductVariant::findOrFail($request->product_variant_id);
        $stocks = Stock::whereHas('productVariant', function ($query) use ($productVariant) {
            $query->where('product_id', $productVariant->product->id);
        })->get();
        if ($productVariant->product->customer_id == $customer->id) {
            return response()->json(['error' => 'Bạn không thể mua gian hàng của mình!'], 403);
        }
        if ($productVariant->type === "Tài khoản") {
            $totalQuantitySuccess = $stocks->flatMap->uidFacebooks->count();
        } elseif ($productVariant->type === "Email") {
            $totalQuantitySuccess = $stocks->flatMap->uidEmails->count();
        }
        if ($request->quantity > $totalQuantitySuccess) {
            return response()->json(['error' => 'Số lượng không hợp lệ!'], 400);
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

            // Kiểm tra xem mã giảm giá có thuộc về sản phẩm của biến thể hay không
            if ($coupon->product_id !== $productVariant->product_id) {
                $coupon = null; // Không lưu mã giảm giá
            } else {
                if ($coupon->type === 'percent') {
                    $discountAmount = min(($total * $coupon->percent) / 100, $coupon->max_amount);
                } else {
                    $discountAmount = $coupon->max_amount;
                }

                $total -= $discountAmount;
            }
        }

        if ($customer->Balance < $total) {
            return response()->json(['error' => 'Số dư không đủ để thanh toán đơn hàng!'], 403);
        }

        if (is_null($productVariant->type)) {
            if (!$request->required) {
                return response()->json(['error' => 'Vui lòng nhập yêu cầu trước khi đặt hàng!'], 400);
            }
        }

        $order = Order::create([
            'customer_id' => $customer->id,
            'product_variant_id' => $productVariant->id,
            'quantity' => $request->quantity,
            'total' => $total,
            'status' => 'pending',
            'discount_amount' => $discountAmount,
            'coupon_id' => $coupon ? $coupon->id : null,
            'required' => $request->required ?? null
        ]);

        $customer->Balance -= $total;
        $customer->save();
        // Tạo Deposit cho người mua ngay lập tức
        Deposit::create([
            'customer_id' => $customer->id,
            'money' => $total,
            'type' => 'mua hàng',
            'content' => 'Thanh toán đơn hàng: ' . $order->order_key,
            'status' => 'thành công'
        ]);
        $seller = $productVariant->product->customer;
        CreateDepositJob::dispatch($order, $seller, $total)->delay(now()->addDays(3));

        if ($productVariant->type === "Tài khoản") {
            $uidFacebooks = $stocks->flatMap->uidFacebooks->take($request->quantity);

            foreach ($uidFacebooks as $facebook) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'account' => $facebook->uid,
                    'value' => $facebook->value,
                    'status' => 'success'
                ]);

                // Xóa UidFacebook khỏi cơ sở dữ liệu
                $facebook->delete();
            }
        } elseif ($productVariant->type === "Email") {
            $uidEmails = $stocks->flatMap->uidEmails->take($request->quantity);

            foreach ($uidEmails as $email) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'account' => $email->email,
                    'value' => $email->value,
                    'status' => 'success'
                ]);

                // Xóa UidEmail khỏi cơ sở dữ liệu
                $email->delete();
            }
        } else {
            $stocks = collect();
        }


        return response()->json(['success' => 'Đơn hàng đã được tạo!', 'order' => $order]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:success,error',
        ]);

        $orderDetail = OrderDetail::findOrFail($id);
        $orderDetail->status = $request->status;
        $orderDetail->save();

        return response()->json(['success' => true]);
    }
}
