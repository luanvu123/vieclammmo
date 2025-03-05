<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function create(ProductVariant $variant)
    {
        return view('admin_customer.stock', compact('variant'));
    }

    public function store(Request $request, ProductVariant $variant)
    {
        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png,pdf,txt,csv|max:2048'
        ]);

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('stocks', 'public');

            Stock::create([
                'product_variant_id' => $variant->id,
                'file' => $filePath,
                'status' => 1
            ]);

            return redirect()->back()
                ->with('success', 'File đã được tải lên thành công chờ hệ thống xác thực');
        }

        return back()->with('error', 'Vui lòng chọn file hợp lệ.');
    }
}
