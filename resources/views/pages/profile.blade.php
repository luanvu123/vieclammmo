@extends('layout')
@section('content')
    <div class="profile-container">
        <div class="profile-left">
            <div class="notification-bar">
                Hãy mua/bán thêm 100.000đ để đạt level tiếp theo.
            </div>

            <div class="profile-field">
                <div class="field-label">Tài khoản</div>
                <div class="field-value">@eriajqqvt24060915</div>
            </div>

            <div class="profile-field">
                <div class="field-label">Họ tên</div>
                <div class="field-value">Chưa đặt tên</div>
            </div>

            <div class="profile-field">
                <div class="field-label">Số dư</div>
                <div class="field-value">000 VND</div>
            </div>

            <div class="profile-field">
                <div class="field-label">Ngày đăng ký</div>
                <div class="field-value">24/02/2025</div>
            </div>

            <div class="profile-field">
                <div class="field-label">Đã mua</div>
                <div class="field-value">0 sản phẩm</div>
            </div>

            <div class="profile-field">
                <div class="field-label">Số gian hàng</div>
                <div class="field-value">0 gian hàng</div>
            </div>

            <div class="profile-field">
                <div class="field-label">Đã bán</div>
                <div class="field-value">0 sản phẩm</div>
            </div>

            <div class="profile-field">
                <div class="field-label">Số bài viết</div>
                <div class="field-value green-text">0 bài viết</div>
            </div>

            <div class="profile-field">
                <div class="field-label">Mua hàng bằng API</div>
                <div class="field-value red-text">✕ Tắt</div>
            </div>

            <div class="profile-field">
                <div class="field-label">Bảo mật 2 lớp</div>
                <div class="field-value green-text">✓ Đã bật</div>
            </div>

            <div class="profile-field">
                <div class="field-label">Kết nối Telegram</div>
                <div class="field-value green-text">✓ Đã kết nối</div>
            </div>

            <div class="profile-field">
                <div class="field-label">Định danh eKYC</div>
                <div class="field-value red-text">✕ Chưa xác thực eKYC</div>
            </div>

            <div style="margin-top: 20px">
                <button class="action-button edit-button" onclick="window.location='{{ route('profile.edit.site') }}'">
                    Chỉnh sửa
                </button>
                <button class="action-button view-store-button">Xem tất cả gian hàng</button>
            </div>

        </div>

        <div class="profile-right">
            <div class="profile-avatar">
                <img src="{{ asset('img/user-icon.png') }}" alt="User Avatar" class="avatar-image">
                <div class="profile-username">@eriajqqvt24060915</div>
                <div class="status-badge">Online</div>
                <div class="status-badge" style="background: #4CAF50">Gian hàng</div>
            </div>

            <div class="login-history">
                <h3>Lịch sử đăng nhập</h3>
                <div class="login-item">
                    24-02-2025 16:12<br>
                    Device: Chrome 133 on Windows
                </div>
                <div class="login-item">
                    24-02-2025 01:51<br>
                    Device: Chrome 133 on Windows
                </div>
                <div class="login-item">
                    24-02-2025 01:14<br>
                    Device: Chrome 133 on Windows
                </div>
                <div class="login-item">
                    24-02-2025 01:02<br>
                    Device: Chrome 133 on Windows
                </div>
            </div>
        </div>
    </div>
@endsection
