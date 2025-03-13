<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    public function create(ProductVariant $variant)
    {
        $customer = Auth::guard('customer')->user();
    if ($customer->isSeller != 1) {
        abort(403, 'Bạn không phải là người bán.');
    }

        if (!$customer || $variant->product->customer_id != $customer->id) {
            abort(403, 'Unauthorized');
        }

        $stocks = $variant->stocks()->with(['uidFacebooks', 'uidEmails'])->get();

        if ($variant->type === "Tài khoản") {
            $data = $stocks->flatMap->uidFacebooks;
        } elseif ($variant->type === "Email") {
            $data = $stocks->flatMap->uidEmails;
        } else {
            $data = collect();
        }

        return view('admin_customer.stock', compact('variant', 'data'));
    }

    public function store(Request $request, ProductVariant $variant)
    {
         $customer = Auth::guard('customer')->user();
    if ($customer->isSeller != 1) {
        abort(403, 'Bạn không phải là người bán.');
    }
        if (!$customer || $variant->product->customer_id !== $customer->id) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png,pdf,txt,csv|max:2048'
        ]);

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('stocks', 'public');

            Stock::create([
                'product_variant_id' => $variant->id,
                'file' => $filePath,
                'status' => 0
            ]);

            return redirect()->back()
                ->with('success', 'File đã được tải lên thành công chờ hệ thống xác thực');
        }

        return back()->with('error', 'Vui lòng chọn file hợp lệ.');
    }
}
