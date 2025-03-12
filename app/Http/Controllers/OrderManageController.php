<?php

namespace App\Http\Controllers;

use App\Models\Order;
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
    // OrderManageController.php



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
