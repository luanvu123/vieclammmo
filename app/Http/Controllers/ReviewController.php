<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index()
    {
        $customer = Auth::guard('customer')->user();

        // Lấy danh sách các đánh giá của khách hàng hiện tại
        $reviews = Review::where('customer_id', $customer->id)
            ->with(['order', 'product'])
            ->get();

        return view('admin_customer.reviews.index', compact('reviews'));
    }


   
public function edit($id)
{
    $review = Review::where('id', $id)
        ->where('customer_id', Auth::guard('customer')->id())
        ->firstOrFail();

    $order = $review->order;
    $product = $order->productVariant->product;

    return view('admin_customer.reviews.edit', compact('review', 'order', 'product'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'content' => 'nullable|string',
        'quality_status' => 'required|array',
    ]);

    $review = Review::where('id', $id)
        ->where('customer_id', Auth::guard('customer')->id())
        ->firstOrFail();

    $qualityStatus = implode(',', $request->quality_status);

    $review->update([
        'rating' => $request->rating,
        'content' => $request->content,
        'quality_status' => $qualityStatus,
    ]);

    return redirect()->route('reviews.index')->with('success', 'Đánh giá đã được cập nhật thành công.');
}

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'nullable|string',
            'quality_status' => 'required|array',
        ]);

        $customer = Auth::guard('customer')->user();
        $qualityStatus = implode(',', $request->quality_status);

        Review::updateOrCreate(
            [
                'customer_id' => $customer->id,
                'order_id' => $request->order_id,
                'product_id' => $request->product_id,
            ],
            [
                'rating' => $request->rating,
                'content' => $request->content,
                'quality_status' => $qualityStatus,
            ]
        );

        return redirect()->route('orders.index')->with('success', 'Cảm ơn bạn đã đánh giá sản phẩm!');
    }

    public function destroy($id)
    {
        $review = Review::where('id', $id)
            ->where('customer_id', Auth::guard('customer')->id())
            ->firstOrFail();
        $review->delete();

        return redirect()->back()->with('success', 'Đánh giá đã được xóa.');
    }
}

