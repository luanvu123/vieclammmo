<?php

namespace App\Jobs;

use App\Models\Deposit;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateDepositJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $order;
    public $seller;
    public $total;

    /**
     * Create a new job instance.
     */
    public function __construct(Order $order, $seller, $total)
    {
        $this->order = $order;
        $this->seller = $seller;
        $this->total = $total;
    }

    /**
     * Execute the job.
     */
  public function handle()
{
    // Tính tổng tiền sau khi trừ chiết khấu 4%
    $totalAfterDiscount = $this->total - ($this->total * 0.04);

    // Cộng tiền vào số dư của người bán
    $this->seller->Balance += $totalAfterDiscount;
    $this->seller->save();

    // Lưu giao dịch vào bảng `deposits`
    Deposit::create([
        'customer_id' => $this->seller->id,
        'money' => $totalAfterDiscount,
        'type' => 'bán hàng',
        'content' => 'Thanh toán đơn hàng sau thời gian tạm giữ: ' . $this->order->order_key,
        'status' => 'thành công'
    ]);
}

}
