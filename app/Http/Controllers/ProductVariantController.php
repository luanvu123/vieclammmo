<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductVariant;

class ProductVariantController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'expiry' => 'nullable|string|max:255',
            'url' => 'nullable|url',
        ]);

        ProductVariant::create($request->all());

        return redirect()->back()->with('success', 'Product Variant Added Successfully!');
    }
    public function destroy(ProductVariant $productVariant)
    {
        $productVariant->delete();
        return redirect()->back()->with('success', 'Đã xóa mặt hàng thành công!');
    }
    // Add this method to your ProductVariantController
    public function update(Request $request, ProductVariant $productVariant)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'expiry' => 'nullable|date',
            'url' => 'nullable|url',
        ]);

        $productVariant->update($request->all());

        // Return JSON response if it's an AJAX request
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product Variant Updated Successfully!'
            ]);
        }

        return redirect()->back()->with('success', 'Product Variant Updated Successfully!');
    }
}
