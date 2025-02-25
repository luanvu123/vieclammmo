@extends('layout')

@section('content')
    <div class="auth-container">
        <div class="auth-form login-form">
            <h2>Đăng nhập</h2>
            <form action="{{ route('login.customer') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required placeholder="Nhập email của bạn">
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu:</label>
                    <input type="password" id="password" name="password" required placeholder="Nhập mật khẩu">
                </div>
                <button type="submit" class="btn primary-btn">Đăng nhập</button>

                <a href="" class="btn google-btn">
                    <i class="fab fa-google"></i> Đăng nhập bằng Google
                </a>
                <a href="{{ route('password.request.customer') }}" class="forgot-password">Quên mật khẩu?</a>
            </form>
        </div>
        <div class="auth-form register-form">
            <h2>Đăng ký</h2>
            <form action="{{ route('register.customer') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Tên:</label>
                    <input type="text" id="name" name="name" required placeholder="Nhập tên của bạn">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required placeholder="Nhập email của bạn">
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu:</label>
                    <input type="password" id="password" name="password" required placeholder="Nhập mật khẩu">
                </div>
                <div class="form-group">
                    <label for="confirm_password">Xác nhận mật khẩu:</label>
                    <input type="password" id="confirm_password" name="password_confirmation" required
                        placeholder="Xác nhận mật khẩu">
                </div>

                <button type="submit" class="btn primary-btn">Đăng ký</button>
            </form>
        </div>
    </div>
@endsection
