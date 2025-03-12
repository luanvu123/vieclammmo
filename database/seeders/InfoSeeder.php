<?php

namespace Database\Seeders;

use App\Models\Info;
use Illuminate\Database\Seeder;

class InfoSeeder extends Seeder
{
    public function run()
    {
        Info::create([
            'email' => 'info@example.com',
            'clock' => '8:00 AM - 5:00 PM',
            'footer' => '© 2025 Example Company. All rights reserved.',
            'rss' => 'https://example.com/rss',
            'youtube' => 'https://youtube.com/example',
            'facebook' => 'https://facebook.com/example',
            'stk' => '123456789',
            'logo_bank' => 'bank_logo.png',
            'account_name' => 'Example Company',
            'account_content' => 'This is the official bank account of Example Company.',
            'qr_code' => 'qr_code.png',
        ]);
    }
}
