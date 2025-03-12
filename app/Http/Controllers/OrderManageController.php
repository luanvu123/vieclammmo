<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\UidEmail;
use App\Models\UidFacebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderManageController extends Controller
{
    public function index()
    {
        $orders = Order::with(['productVariant.product.category', 'orderDetails', 'customer', 'coupon'])
            ->whereHas('productVariant.product', function ($query) {
                $query->where('customer_id', Auth::guard('customer')->id())
                      ->whereHas('category', function ($q) {
                          $q->where('type', 'Sản phẩm');
                      });
            })
            ->get();

        return view('orders.index', compact('orders'));
    }
     public function orderDetail($id)
    {
        $order = Order::with(['orderDetails', 'productVariant.product.category', 'customer'])
                      ->findOrFail($id);

        return view('orders.order-detail', compact('order'));
    }

public function warranty(Request $request, Order $order)
{
    $request->validate([
        'quantity' => 'required|integer|min:1|max:' . $order->quantity,
    ]);

    $quantity = $request->quantity;

    if ($order->productVariant->type === "Tài khoản") {
        $stocks = $order->productVariant->stocks->flatMap->uidFacebooks->take($quantity);

        foreach ($stocks as $stock) {
            OrderDetail::create([
                'order_id' => $order->id,
                'account' => $stock->uid,
                'value' => $stock->value,
                'status' => 'success'
            ]);

            // Xóa UidFacebook có uid tương ứng
            UidFacebook::where('uid', $stock->uid)->delete();
        }
    } elseif ($order->productVariant->type === "Email") {
        $stocks = $order->productVariant->stocks->flatMap->uidEmails->take($quantity);

        foreach ($stocks as $stock) {
            OrderDetail::create([
                'order_id' => $order->id,
                'account' => $stock->email,
                'value' => $stock->value,
                'status' => 'success'
            ]);

            // Xóa UidEmail có email tương ứng
            UidEmail::where('email', $stock->email)->delete();
        }
    } else {
        return redirect()->back()->with('error', 'Sản phẩm không hỗ trợ bảo hành.');
    }

    return redirect()->back()->with('success', 'Yêu cầu bảo hành đã được xử lý thành công.');
}



public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:completed,canceled,pending'
    ]);

    $order = Order::findOrFail($id);
    $order->status = $request->status;
    $order->save();

    return redirect()->route('order-manage.index')->with('success', 'Order status updated successfully.');
}

}
