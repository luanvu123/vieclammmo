<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductManageController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.product.index', compact('products'));
    }

    public function edit(Product $product)
    {
        return view('admin.product.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'is_hot' => 'required|boolean',
            'status' => 'required|in:active,inactive',
        ]);

        $product->update($request->only(['is_hot', 'status']));

        return redirect()->route('product-manage.index')->with('success', 'Cập nhật thành công');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('product-manage.index')->with('success', 'Xóa sản phẩm thành công');
    }
}
