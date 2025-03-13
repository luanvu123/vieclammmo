<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewManageController extends Controller
{
    public function index()
    {
         $customer = Auth::guard('customer')->user();
    if ($customer->isSeller != 1) {
        abort(403, 'Bạn không phải là người bán.');
    }
        $customerId = Auth::guard('customer')->id();

        $reviews = Review::whereHas('order.productVariant.product', function ($query) use ($customerId) {
            $query->where('customer_id', $customerId);
        })->with(['customer', 'order', 'product'])->get();

        return view('admin_customer.review_seller.index', compact('reviews'));
    }
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->route('index-manage')->with('success', 'Review deleted successfully.');
    }
}
