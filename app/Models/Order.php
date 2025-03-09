<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_key',
        'customer_id',
        'product_variant_id',
        'quantity',
        'total',
        'status',
        'coupon_id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $order->order_key = self::generateOrderKey();
        });
    }

    public static function generateOrderKey()
    {
        return 'ORD-' . strtoupper(uniqid());
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

}

