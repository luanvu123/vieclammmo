<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'clock',
        'footer',
        'rss',
        'youtube',
        'facebook',
        'stk',
        'logo_bank',
        'account_name',
        'account_content',
        'qr_code'
    ];
}
