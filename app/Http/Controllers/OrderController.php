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
        try {
            if (!Auth::guard('customer')->check()) {
                return response()->json(['error' => 'Bạn cần đăng nhập để mua hàng!'], 403);
            }

            $validated = $request->validate([
                'product_variant_id' => 'required|exists:product_variants,id',
                'quantity' => 'required|integer|min:1',
                'coupon_key' => 'nullable|string',
                'required' => 'nullable|string'
            ]);

            $customer = Auth::guard('customer')->user();
            $productVariant = ProductVariant::findOrFail($request->product_variant_id);
            $product = $productVariant->product;

            // Check if customer is trying to buy their own product
            if ($product->customer_id == $customer->id) {
                return response()->json(['error' => 'Bạn không thể mua gian hàng của mình!'], 403);
            }

            // Check product stock for account/email types
            // For checking product stock with specific variant condition
            $totalQuantitySuccess = 1; // Default value for most products
            if ($productVariant->type === "Tài khoản" || $productVariant->type === "Email") {
                $stocks = Stock::where('product_variant_id', $productVariant->id)->get();

                if ($productVariant->type === "Tài khoản") {
                    $totalQuantitySuccess = $stocks->flatMap->uidFacebooks->count();
                } elseif ($productVariant->type === "Email") {
                    $totalQuantitySuccess = $stocks->flatMap->uidEmails->count();
                }

                if ($request->quantity > $totalQuantitySuccess) {
                    return response()->json(['error' => 'Số lượng không hợp lệ!'], 400);
                }
            }


            // Calculate total and apply coupon if available
            $total = $productVariant->price * $request->quantity;
            $coupon = null;
            $discountAmount = 0;

            if ($request->coupon_key) {
                $coupon = Coupon::where('coupon_key', $request->coupon_key)
                    ->where('status', 'active')
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now())
                    ->first();

                if ($coupon) {
                    // Verify coupon is for this product
                    if ($coupon->product_id === $product->id) {
                        if ($coupon->type === 'percent') {
                            $discountAmount = min(($total * $coupon->percent) / 100, $coupon->max_amount);
                        } else {
                            $discountAmount = $coupon->max_amount;
                        }
                        $total -= $discountAmount;
                    }
                }
            }

            // Check if customer has enough balance
            if ($customer->Balance < $total) {
                return response()->json(['error' => 'Số dư không đủ để thanh toán đơn hàng!'], 403);
            }

            // Check if required field is needed (for service category)
            if ($product->category->type === "Dịch vụ" && empty($request->required)) {
                return response()->json(['error' => 'Vui lòng nhập yêu cầu trước khi đặt hàng!'], 400);
            }

            // Create the order
            $order = Order::create([
                'customer_id' => $customer->id,
                'product_variant_id' => $productVariant->id,
                'quantity' => $request->quantity,
                'total' => $total,
                'status' => 'pending',
                'discount_amount' => $discountAmount,
                'coupon_id' => $coupon ? $coupon->id : null,
                'required' => ($product->category->type === "Dịch vụ") ? $request->required : null
            ]);

            // Update customer balance
            $customer->Balance -= $total;
            $customer->save();

            // Create deposit record
            Deposit::create([
                'customer_id' => $customer->id,
                'money' => $total,
                'type' => 'mua hàng',
                'content' => 'Thanh toán đơn hàng: ' . $order->order_key,
                'status' => 'thành công'
            ]);

            // Schedule deposit for seller
            $seller = $product->customer;
            CreateDepositJob::dispatch($order, $seller, $total)->delay(now()->addDays(3));

            if ($productVariant->type === "Tài khoản") {
                $stocks = Stock::where('product_variant_id', $productVariant->id)->get();
                $uidFacebooks = $stocks->flatMap(function ($stock) {
                    return $stock->uidFacebooks;
                })->take($request->quantity);

                foreach ($uidFacebooks as $facebook) {
                    OrderDetail::create([
                        'order_id' => $order->id,
                        'account' => $facebook->uid,
                        'value' => $facebook->value,
                        'status' => 'success'
                    ]);

                    // Delete the used Facebook UID
                    $facebook->delete();
                }
            } elseif ($productVariant->type === "Email") {
                $stocks = Stock::where('product_variant_id', $productVariant->id)->get();
                $uidEmails = $stocks->flatMap(function ($stock) {
                    return $stock->uidEmails;
                })->take($request->quantity);

                foreach ($uidEmails as $email) {
                    OrderDetail::create([
                        'order_id' => $order->id,
                        'account' => $email->email,
                        'value' => $email->value,
                        'status' => 'success'
                    ]);

                    // Delete the used Email
                    $email->delete();
                }
            }

            return response()->json(['success' => 'Đơn hàng đã được tạo!', 'order' => $order]);
        } catch (\Exception $e) {
            \Log::error('Order creation error: ' . $e->getMessage());
            return response()->json(['error' => 'Đã xảy ra lỗi: ' . $e->getMessage()], 500);
        }
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
