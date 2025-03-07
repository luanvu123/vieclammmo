@extends('layout')
@section('content')
    <div class="profile-container">
        <div class="profile-left">
            <div class="profile-field">
                <div class="field-label">Tài khoản</div>
                <div class="field-value">{{ $customer->email }}</div>
            </div>

            <div class="profile-field">
                <div class="field-label">Họ tên</div>
                <div class="field-value">{{ $customer->name }}</div>
            </div>

            <div class="profile-field">
                <div class="field-label">Số dư</div>
                <div class="field-value">{{ number_format($customer->Balance, 0, ',', '.') }} VND</div>

            </div>

            <div class="profile-field">
                <div class="field-label">Ngày đăng ký</div>
                <div class="field-value">{{ $customer->created_at->format('d/m/Y') }}</div>
            </div>

            <div class="profile-field">
                <div class="field-label">Đã mua</div>
                <div class="field-value">{{ $productsBought }} sản phẩm</div>
            </div>

            <div class="profile-field">
                <div class="field-label">Số gian hàng</div>
                <div class="field-value">{{ $storesCount }} gian hàng</div>
            </div>

            <div class="profile-field">
                <div class="field-label">Đã bán</div>
                <div class="field-value">{{ $productsSold }} sản phẩm</div>
            </div>

            <div class="profile-field">
                <div class="field-label">Số bài viết</div>
                <div class="field-value green-text">{{ $postsCount }} bài viết</div>
            </div>

            <div class="profile-field">
                <div class="field-label">Mua hàng bằng API</div>
                <div class="field-value {{ $customer->isApi ? 'green-text' : 'red-text' }}">
                    {{ $customer->isApi ? '✓ Đã bật' : '✕ Tắt' }}
                </div>
            </div>

            <div class="profile-field">
                <div class="field-label">Bảo mật 2 lớp</div>
                <div class="field-value {{ $customer->is2Fa ? 'green-text' : 'red-text' }}">
                    {{ $customer->is2Fa ? '✓ Đã bật' : '✕ Tắt' }}
                </div>
            </div>

            <div class="profile-field">
                <div class="field-label">Kết nối Telegram</div>
                <div class="field-value {{ $customer->isTelegram ? 'green-text' : 'red-text' }}">
                    {{ $customer->isTelegram ? '✓ Đã kết nối' : '✕ Chưa kết nối' }}
                </div>
            </div>

            <div class="profile-field">
                <div class="field-label">Trạng thái</div>
                <div class="field-value {{ $isOnline ? 'green-text' : 'red-text' }}">
                    {{ $isOnline ? 'Online' : 'Offline' }}
                </div>
            </div>

            <div class="profile-field">
                <div class="field-label">Định danh eKYC</div>
                <div class="field-value {{ $customer->isEkyc ? 'green-text' : 'red-text' }}">
                    {{ $customer->isEkyc ? '✓ Đã định danh' : '✕ Chưa định danh' }}
                </div>
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
                <img src="{{ $customer->avatar ? asset('storage/' . $customer->avatar) : asset('img/user-icon.png') }}"
                    alt="User Avatar" class="avatar-image">
                <div class="profile-username">{{ $customer->email }}</div>
                <div class="status-badge">{{ $isOnline ? 'Online' : 'Offline' }}</div>
                <div class="status-badge" style="background: #4CAF50">Gian hàng</div>
            </div>

            <div class="login-history">
                <h3>Lịch sử đăng nhập</h3>
                @forelse ($loginHistories as $history)
                    <div class="login-item">
                        {{ $history->login_time->format('d-m-Y H:i') }}<br>
                        Device: {{ $history->device }}
                    </div>
                @empty
                    <div class="login-item">
                        Chưa có lịch sử đăng nhập.
                    </div>
                @endforelse
            </div>

        </div>
    </div>
@endsection
