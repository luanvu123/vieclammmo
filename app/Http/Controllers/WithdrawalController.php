<?php

// app/Http/Controllers/WithdrawalController.php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use App\Models\Deposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawalController extends Controller
{
    public function create()
    {
        return view('pages.withdrawals');
    }

    public function store(Request $request)
    {
        $request->validate([
            'bank' => 'required|string',
            'bankAccName' => 'required|string',
            'bankAccNum' => 'required|string',
            'amount' => 'required|numeric|min:0',
        ]);

        $customer = Auth::guard('customer')->user();

        if ($request->amount > $customer->Balance) {
            return back()->with('error', 'Số dư không đủ để thực hiện rút tiền.');
        }

        // Tạo bản ghi rút tiền
        $withdrawal = Withdrawal::create([
            'customer_id' => $customer->id,
            'bank' => $request->bank,
            'bankAccName' => $request->bankAccName,
            'bankAccNum' => $request->bankAccNum,
            'amount' => $request->amount,
            'status' => 'đang chờ',
        ]);

        // Tạo bản ghi Deposit
        Deposit::create([
            'customer_id' => $customer->id,
            'money' => -$request->amount,
            'type' => 'rút tiền',
            'content' => 'Rút tiền qua ngân hàng ' . $request->bank,
            'status' => 'đang chờ',
        ]);

        // Giảm số dư của người dùng
        $customer->Balance -= $request->amount;
        $customer->save();

        return redirect()->route('withdrawals.index')->with('success', 'Yêu cầu rút tiền đã được gửi.');
    }
    public function index()
{
    $customer = Auth::guard('customer')->user();
    $withdrawals = Withdrawal::where('customer_id', $customer->id)
                            ->orderBy('created_at', 'desc')
                            ->get();

    return view('pages.withdrawls_index', compact('withdrawals'));
}

}

