@extends('layout')

@section('content')
    <div class="auth-container">
        <div class="auth-form login-form">
            <h2>Quên mật khẩu</h2>
            <form action="{{ route('password.email.customer') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required placeholder="Nhập email của bạn">
                </div>
                <button type="submit" class="btn primary-btn">Gửi yêu cầu đặt lại mật khẩu</button>
            </form>
        </div>
    </div>
@endsection
