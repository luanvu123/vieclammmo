<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintManageController extends Controller
{
    public function index()
    {
        $customer = Auth::guard('customer')->user();

        if ($customer->isSeller != 1) {
            abort(403, 'Bạn không phải là người bán.');
        }

        $complaints = Complaint::with(['customer', 'order.productVariant.product'])
            ->whereHas('order.productVariant.product', function ($query) use ($customer) {
                $query->where('customer_id', $customer->id);
            })->get();

        return view('admin_customer.complaints.index', compact('complaints'));
    }

    public function edit($id)
    {
        $customer = Auth::guard('customer')->user();

        if ($customer->isSeller != 1) {
            abort(403, 'Bạn không phải là người bán.');
        }

        $complaint = Complaint::whereHas('order.productVariant.product', function ($query) use ($customer) {
            $query->where('customer_id', $customer->id);
        })->find($id);

        if (!$complaint) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin_customer.complaints.edit', compact('complaint'));
    }

    public function update(Request $request, $id)
    {
        $customer = Auth::guard('customer')->user();

        if ($customer->isSeller != 1) {
            abort(403, 'Bạn không phải là người bán.');
        }

        $complaint = Complaint::whereHas('order.productVariant.product', function ($query) use ($customer) {
            $query->where('customer_id', $customer->id);
        })->findOrFail($id);

        $complaint->update($request->only('status'));

        return redirect()->route('complaints.index')->with('success', 'Complaint updated successfully.');
    }

    public function destroy($id)
    {
        $customer = Auth::guard('customer')->user();

        if ($customer->isSeller != 1) {
            abort(403, 'Bạn không phải là người bán.');
        }

        $complaint = Complaint::whereHas('order.productVariant.product', function ($query) use ($customer) {
            $query->where('customer_id', $customer->id);
        })->findOrFail($id);

        $complaint->delete();

        return redirect()->route('complaints.index')->with('success', 'Complaint deleted successfully.');
    }

    public function updateStatus(Request $request, $id)
    {
        $customer = Auth::guard('customer')->user();

        if ($customer->isSeller != 1) {
            abort(403, 'Bạn không phải là người bán.');
        }

        $complaint = Complaint::whereHas('order.productVariant.product', function ($query) use ($customer) {
            $query->where('customer_id', $customer->id);
        })->findOrFail($id);

        $complaint->update(['status' => $request->status]);

        return redirect()->route('complaints.index')->with('success', 'Complaint status updated successfully.');
    }
}
