<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'password',
        'google_id',
        'isEkyc',
        'last_active_at',
        'account_number',
        'isSeller'

    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $dates = ['last_active_at'];
    protected $casts = [
    'last_active_at' => 'datetime',
];

    public static function generateUniqueId()
    {
        do {
            // Tạo mã 6 chữ số ngẫu nhiên
            $idCustomer = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
        } while (self::where('idCustomer', $idCustomer)->exists());

        return $idCustomer;
    }

    public function loginHistories()
    {
        return $this->hasMany(LoginHistory::class);
    }
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
     // Tin nhắn gửi đi
    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    // Tin nhắn nhận được
    public function receivedMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    // Lấy tất cả tin nhắn liên quan (cả gửi và nhận)
    public function messages()
    {
        return Message::where('sender_id', $this->id)
            ->orWhere('receiver_id', $this->id);
    }
public function unreadMessagesCount()
{
    return $this->receivedMessages()->where('is_read', false)->count();
}

}
