<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = ['product_variant_id', 'file', 'status', 'quantity_success', 'quantity_error'];

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
    public function uidFacebooks()
    {
        return $this->hasMany(UidFacebook::class);
    }
    public function uidEmails()
    {
        return $this->hasMany(UidEmail::class);
    }

}

