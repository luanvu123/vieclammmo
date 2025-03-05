<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductVariantManageController extends Controller
{
    public function listByProduct(Product $product)
    {
        $productVariants = $product->productVariants; // Lấy danh sách biến thể của sản phẩm
        return view('admin.product_variant.index', compact('product', 'productVariants'));
    }
    public function edit(ProductVariant $productVariant)
    {
        return view('admin.product_variant.edit', compact('productVariant'));
    }

    public function update(Request $request, ProductVariant $productVariant)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
            'expiry' => 'nullable|date',
            'url' => 'nullable|url'
        ]);

        $productVariant->update($request->all());

        return redirect()->route('product-manage.index')->with('success', 'Cập nhật thành công');
    }

    public function destroy(ProductVariant $productVariant)
    {
        $productVariant->delete();
        return redirect()->route('product-manage.index')->with('success', 'Xóa thành công');
    }
}
