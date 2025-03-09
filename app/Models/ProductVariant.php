<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'price',
        'status',
        'expiry',
        'url',
        'type',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
