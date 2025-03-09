<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'coupon_key', 'product_id', 'start_date', 'end_date', 'usage',
        'type', 'percent', 'max_amount', 'description', 'status'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

