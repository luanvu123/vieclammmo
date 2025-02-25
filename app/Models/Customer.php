<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'email',
        'name',
        'avatar',
        'phone',
        'url_facebook',
        'Front_ID_card_image',
        'Back_ID_card_image',
        'Portrait_image',
        'isTelegram',
        'isApi',
        'is2Fa',
        'google2fa_secret',
        'idCustomer',
        'Balance',
        'isOnline',
        'Status',
        'password'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public static function generateUniqueId()
    {
        do {
            // Tạo mã 6 chữ số ngẫu nhiên
            $idCustomer = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
        } while (self::where('idCustomer', $idCustomer)->exists());

        return $idCustomer;
    }
}
