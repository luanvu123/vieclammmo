<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::with('product')->whereHas('product', function ($query) {
            $query->where('customer_id', Auth::guard('customer')->id());
        })->get();

        return view('admin_customer.coupon.index', compact('coupons'));
    }

    public function create()
    {
        $products = Product::where('customer_id', Auth::guard('customer')->id())->get();
        return view('admin_customer.coupon.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'coupon_key' => 'required|unique:coupons,coupon_key',
            'product_id' => [
                'required',
                Rule::exists('products', 'id')->where('customer_id', Auth::guard('customer')->id()),
            ],
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'type' => 'required|in:percent,fixed',
            'percent' => 'nullable|integer|min:0|max:100',
            'max_amount' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        Coupon::create($request->all());

        return redirect()->route('coupons.index')->with('success', 'Mã giảm giá đã được thêm.');
    }

    public function edit(Coupon $coupon)
    {
        if ($coupon->product->customer_id !== Auth::guard('customer')->id()) {
            return redirect()->route('coupons.index')->with('error', 'Bạn không có quyền chỉnh sửa mã giảm giá này.');
        }

        $products = Product::where('customer_id', Auth::guard('customer')->id())->get();
        return view('admin_customer.coupon.edit', compact('coupon', 'products'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        if ($coupon->product->customer_id !== Auth::guard('customer')->id()) {
            return redirect()->route('coupons.index')->with('error', 'Bạn không có quyền chỉnh sửa mã giảm giá này.');
        }

        $request->validate([
            'coupon_key' => [
                'required',
                Rule::unique('coupons', 'coupon_key')->ignore($coupon->id),
            ],
            'product_id' => [
                'required',
                Rule::exists('products', 'id')->where('customer_id', Auth::guard('customer')->id()),
            ],
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'type' => 'required|in:percent,fixed',
            'percent' => 'nullable|integer|min:0|max:100',
            'max_amount' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $coupon->update($request->all());

        return redirect()->route('coupons.index')->with('success', 'Mã giảm giá đã được cập nhật.');
    }
}
