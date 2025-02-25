<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $resetUrl = route('password.reset.customer', ['token' => $this->token]);

        return (new MailMessage)
            ->subject('Đặt lại mật khẩu')
            ->view('emails.reset-password', [
                'customer' => $notifiable,
                'resetUrl' => $resetUrl,
            ]);
    }
}
