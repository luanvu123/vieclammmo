<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $customerId = Auth::guard('customer')->id();
        $wishlistProducts = Wishlist::where('customer_id', $customerId)->with('product')->paginate(10);

        return view('customer.wishlist.index', compact('wishlistProducts'));
    }

    public function store(Request $request)
    {
        $customerId = Auth::guard('customer')->id();

        Wishlist::firstOrCreate([
            'customer_id' => $customerId,
            'product_id' => $request->product_id
        ]);

        return back()->with('success', 'Đã thêm vào danh sách yêu thích!');
    }

    public function destroy($id)
    {
        $customerId = Auth::guard('customer')->id();
        Wishlist::where('customer_id', $customerId)->where('product_id', $id)->delete();

        return back()->with('success', 'Đã xóa khỏi danh sách yêu thích!');
    }
}
