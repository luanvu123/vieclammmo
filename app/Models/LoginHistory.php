<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class LoginHistory extends Model
{

    protected $fillable = ['customer_id', 'device', 'login_time'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
     public function getLoginTimeAttribute($value)
    {
        return Carbon::parse($value);
    }
}
