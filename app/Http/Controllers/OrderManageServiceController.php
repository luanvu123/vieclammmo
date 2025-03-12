<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderManageServiceController extends Controller
{
    public function index()
    {
        $orders = Order::with(['productVariant.product.category', 'orderDetails', 'customer', 'coupon'])
            ->whereHas('productVariant.product', function ($query) {
                $query->where('customer_id', Auth::guard('customer')->id())
                    ->whereHas('category', function ($q) {
                        $q->where('type', 'Dịch vụ');
                    });
            })
            ->get();

        return view('order-service.index', compact('orders'));
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
