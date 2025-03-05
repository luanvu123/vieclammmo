<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UidFacebook extends Model
{
    use HasFactory;

    protected $fillable = ['stock_id', 'uid', 'status'];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
