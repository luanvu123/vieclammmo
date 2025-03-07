<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
        'attachment',
        'status'
    ];

    // Quan hệ với người gửi
    public function sender()
    {
        return $this->belongsTo(Customer::class, 'sender_id');
    }

    // Quan hệ với người nhận
    public function receiver()
    {
        return $this->belongsTo(Customer::class, 'receiver_id');
    }
}
