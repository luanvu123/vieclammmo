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

}
