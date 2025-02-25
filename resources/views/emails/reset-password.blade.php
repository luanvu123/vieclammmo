@component('mail::message')
# Đặt lại mật khẩu

Xin chào {{ $customer->name }},

Chúng tôi đã nhận được yêu cầu đặt lại mật khẩu của bạn. Nhấn vào nút bên dưới để đặt lại mật khẩu:

@component('mail::button', ['url' => $resetUrl])
Đặt lại mật khẩu
@endcomponent

Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này.

Cảm ơn,<br>
{{ config('app.name') }}
@endcomponent
