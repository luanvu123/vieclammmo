<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CustomerManageController extends Controller
{

    public function index()
    {
        $customers = Customer::all();
        return view('admin.customers.index', compact('customers'));
    }
    public function edit(Customer $customerManage)
    {
         $customerManage->last_active_at = now();
        return view('admin.customers.edit', compact('customerManage'));
    }
    public function update(Request $request, Customer $customerManage)
    {
        $request->validate([
            'Balance' => 'required|numeric',
            'password' => 'nullable|min:6',
            'Status' => 'required|boolean',
            'isEkyc' => 'required|boolean'
        ]);

        $data = [
            'Balance' => $request->Balance,
            'Status' => $request->Status,
            'isEkyc' => $request->isEkyc
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $customerManage->update($data);

        return redirect()->route('customer-manage.index')
            ->with('success', 'Thông tin khách hàng đã được cập nhật thành công.');
    }
}
