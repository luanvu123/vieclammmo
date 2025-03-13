<?php

// app/Models/Withdrawal.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'bank',
        'bankAccName',
        'bankAccNum',
        'amount',
        'status'
    ];

    public function customer()
{
    return $this->belongsTo(Customer::class);
}

}

