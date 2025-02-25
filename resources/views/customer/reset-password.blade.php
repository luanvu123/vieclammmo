@extends('layout')

@section('content')
    <div class="auth-container">
        <div class="auth-form login-form">
            <h2>Đặt lại mật khẩu</h2>
            <form action="{{ route('password.update.customer') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required placeholder="Nhập email của bạn">
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu mới:</label>
                    <input type="password" id="password" name="password" required placeholder="Nhập mật khẩu mới">
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Xác nhận mật khẩu:</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Xác nhận mật khẩu">
                </div>
                <button type="submit" class="btn primary-btn">Đặt lại mật khẩu</button>
            </form>
        </div>
    </div>
@endsection
