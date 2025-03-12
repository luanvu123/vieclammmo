<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintManageController extends Controller
{
    public function index()
    {
        $customerId = Auth::guard('customer')->id();

        $complaints = Complaint::with(['customer', 'order.productVariant.product'])
            ->whereHas('order.productVariant.product', function ($query) use ($customerId) {
                $query->where('customer_id', $customerId);
            })->get();

        return view('admin_customer.complaints.index', compact('complaints'));
    }

  public function edit($id)
{
    $customerId = Auth::guard('customer')->id();

    $complaint = Complaint::whereHas('order.productVariant.product', function ($query) use ($customerId) {
            $query->where('customer_id', $customerId);
        })
        ->find($id);

    if (!$complaint) {
        abort(403, 'Unauthorized action.');
    }

    return view('admin_customer.complaints.edit', compact('complaint'));
}


    public function update(Request $request, $id)
    {
        $customerId = Auth::guard('customer')->id();

        $complaint = Complaint::whereHas('order.productVariant.product', function ($query) use ($customerId) {
                $query->where('customer_id', $customerId);
            })
            ->findOrFail($id);

        $complaint->update($request->only('status'));

        return redirect()->route('complaints.index')->with('success', 'Complaint updated successfully.');
    }

    public function destroy($id)
    {
        $customerId = Auth::guard('customer')->id();

        $complaint = Complaint::whereHas('order.productVariant.product', function ($query) use ($customerId) {
                $query->where('customer_id', $customerId);
            })
            ->findOrFail($id);

        $complaint->delete();

        return redirect()->route('complaints.index')->with('success', 'Complaint deleted successfully.');
    }

    public function updateStatus(Request $request, $id)
{
    $customerId = Auth::guard('customer')->id();

    $complaint = Complaint::whereHas('order.productVariant.product', function ($query) use ($customerId) {
            $query->where('customer_id', $customerId);
        })
        ->findOrFail($id);

    $complaint->update(['status' => $request->status]);

    return redirect()->route('complaints.index')->with('success', 'Complaint status updated successfully.');
}

}

