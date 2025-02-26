@extends('layout')

@section('content')
    <style>
        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
        }

        .popup-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            width: 80%;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            position: relative;
        }

        .close-btn {
            position: absolute;
            top: 5px;
            right: 10px;
            font-size: 24px;
            cursor: pointer;
            color: #333;
        }
    </style>
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


                <a href="javascript:void(0);" class="forgot-password" onclick="openPopup()">Quên mật khẩu?</a>

            </form>
            <a href="{{ route('login.google') }}" class="btn google-btn">
                <i class="fab fa-google"></i> Đăng nhập bằng Google
            </a>

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
    <!-- Popup Thông báo -->
    <div id="forgot-password-popup" class="popup">
        <div class="popup-content">
            <span class="close-btn" onclick="closePopup()">&times;</span>
            <p>Vui lòng liên hệ Zalo: <strong>09876543211</strong> để lấy lại mật khẩu.</p>
        </div>
    </div>
    <script>
        function openPopup() {
            document.getElementById("forgot-password-popup").style.display = "block";
        }

        function closePopup() {
            document.getElementById("forgot-password-popup").style.display = "none";
        }

        // Đóng popup khi nhấn ra ngoài
        window.onclick = function(event) {
            var popup = document.getElementById("forgot-password-popup");
            if (event.target === popup) {
                popup.style.display = "none";
            }
        }
    </script>
@endsection
