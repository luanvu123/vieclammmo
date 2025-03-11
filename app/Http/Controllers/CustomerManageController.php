<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Deposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
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
     public function indexDeposit($customerId)
    {
        $deposits = Deposit::where('customer_id', $customerId)->get();
        $customer = Customer::findOrFail($customerId);

        return view('admin.customers.deposit', compact('deposits', 'customer'));
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
       public function storeDeposit(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'money' => 'required|numeric|min:0',
            'type' => 'required|in:nạp tiền,rút tiền',
            'content' => 'nullable|string'
        ]);

        $customer = Customer::findOrFail($request->customer_id);

        DB::transaction(function () use ($request, $customer) {
            if ($request->type === 'rút tiền' && $customer->Balance < $request->money) {
                return back()->with('error', 'Số dư không đủ để rút tiền.');
            }

            $deposit = Deposit::create([
                'customer_id' => $customer->id,
                'money' => $request->money,
                'type' => $request->type,
                'content' => $request->content,
                'status' => 'thành công'
            ]);

            if ($request->type === 'nạp tiền') {
                $customer->Balance += $request->money;
            } else {
                $customer->Balance -= $request->money;
            }

            $customer->save();
        });

        return redirect()->route('customer-manage.index')->with('success', 'Giao dịch đã được thực hiện thành công.');
    }
}
