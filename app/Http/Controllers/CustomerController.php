<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function profile()
    {
        $customer = Auth::guard('customer')->user();
        return view('pages.profile', compact('customer'));
    }
    public function profileEdit()
    {
        $customer = Auth::guard('customer')->user();
        return view('pages.profile_edit', compact('customer'));
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'url_facebook' => 'nullable|url',
        ]);

        $customer = Auth::guard('customer')->user();
        $customer->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'url_facebook' => $request->url_facebook,
        ]);

        return redirect()->route('profile.site')->with('success', 'Cập nhật hồ sơ thành công.');
    }
}
