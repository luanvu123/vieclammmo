@extends('layout')
@section('content')
    <div class="profile-container">
        <div class="edit-form">
            <form action="{{ route('profile.update.site') }}" method="POST">
                @csrf

                <div class="edit-form">
                    <div class="form-section">
                        <div class="form-row">
                            <div class="form-label">Họ và tên</div>
                            <div class="form-input">
                                <input type="text" name="name" value="{{ old('name', $customer->name) }}" required>
                                @error('name')
                                    <div class="alert-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-label">Số điện thoại</div>
                            <div class="form-input">
                                <input type="tel" name="phone" value="{{ old('phone', $customer->phone) }}">
                                @error('phone')
                                    <div class="alert-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-label">Email</div>
                            <div class="form-input">
                                <input type="email" value="{{ $customer->email }}" disabled>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-label">Facebook</div>
                            <div class="form-input">
                                <input type="text" name="url_facebook"
                                    value="{{ old('url_facebook', $customer->url_facebook) }}">
                                @error('url_facebook')
                                    <div class="alert-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-label"></div>
                            <div class="form-input">
                                <button class="action-btn" type="submit">Lưu lại</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="form-section">
                <div class="form-section-title">Định danh eKYC</div>

                <div class="form-row">
                    <div class="form-label">Ảnh CMND mặt trước</div>
                    <div class="form-input">
                        <button class="upload-btn">Chọn ảnh</button>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-label">Ảnh CMND mặt sau</div>
                    <div class="form-input">
                        <button class="upload-btn">Chọn ảnh</button>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-label">Ảnh chân dung</div>
                    <div class="form-input">
                        <button class="upload-btn">Chọn ảnh</button>
                        <div class="alert-info">Hình ảnh phải rõ nét và rõ khuôn mặt để xác thực</div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-label"></div>
                    <div class="form-input">
                        <button class="action-btn">Xác thực eKYC</button>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <div class="form-section-title">Telegram: Kết nối để dễ tín nhận</div>

                <div class="form-row">
                    <div class="form-label"></div>
                    <div class="form-input">
                        <div class="toggle-btn">
                            <input type="checkbox" checked> Đã kết nối
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-label"></div>
                    <div class="form-input">
                        <button class="delete-btn">Ngưng kết nối Telegram</button>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <div class="form-section-title">Bảo mật 2 lớp</div>

                <div class="form-row">
                    <div class="form-label"></div>
                    <div class="form-input">
                        <ul style="margin: 0; padding-left: 20px; font-size: 14px; color: #666;">
                            <li>Bật bảo mật hai lớp bằng code 2FA cho tài khoản của bạn.</li>
                            <li>Mỗi khi đăng nhập hệ thống sẽ yêu cầu 1 mã 6 số được tạo từ chuỗi 2FA. Đề phòng trường hợp
                                bạn bị lộ pass hoặc lộ email.</li>
                        </ul>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-label"></div>
                    <div class="form-input">
                        <button class="action-btn">Bật</button>
                    </div>
                </div>

                {{-- <div class="form-row">
                    <div class="form-label"></div>
                    <div class="form-input">
                        <div class="toggle-btn">
                            <input type="checkbox" checked> Đã bật
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-label"></div>
                    <div class="form-input">
                        <button class="delete-btn">Tắt</button>
                    </div>
                </div> --}}
            </div>

            <div class="form-section">
                <div class="form-section-title">Mua hàng bằng API</div>

                <div class="form-row">
                    <div class="form-label"></div>
                    <div class="form-input">
                        <ul style="margin: 0; padding-left: 20px; font-size: 14px; color: #666;">
                            <li>Mỗi tài khoản sẽ nhận một token riêng, duy nhất để tích hợp vào phần mềm. Lưu ý token sẽ chỉ
                                hiện một lần nên hãy lưu giữ cẩn thận.</li>
                            <li>Đối với các sản phẩm hàng hóa, trạng thái thì sẽ hiển thị ngay trong phần trạng thái hàng,
                                bạn có thể truy cập vào tài khoản để xem lịch sử mua hàng của mình.</li>
                            <li>Để thực hiện hàng, vui lòng lập trình API.</li>
                        </ul>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-label"></div>
                    <div class="form-input">
                        <button class="action-btn">Bật</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="popup-2fa" id="popup-2fa">
        <div class="popup-content">
            <h3>Bật bảo mật 2 lớp</h3>
            <p>Sử dụng app Google Authenticator trên điện thoại của bạn và quét mã này</p>
            <img src="#" alt="QR Code" style="width: 150px; height: 150px;">
            <p>Hoặc sử dụng chuỗi code sau để lấy mã đăng nhập:</p>
            <p class="code-2fa">PSTBJ6ZVQIIAIQJB</p>
            <a href="#" class="download-2fa">Tải code 2fa</a>
            <p style="color: red;">*Lưu ý: hãy lưu lại chuỗi mã này, nếu mất bạn sẽ không thể đăng nhập vào tài khoản.</p>
            <input type="text" placeholder="Mã đăng nhập 6 số">
            <div class="popup-actions">
                <button class="close-btn">Đóng</button>
                <button class="confirm-btn">Xác nhận</button>
            </div>
        </div>
    </div>
    <script>
        document.querySelector('.action-btn').addEventListener('click', function() {
            document.getElementById('popup-2fa').style.display = 'block';
        });

        document.querySelector('.close-btn').addEventListener('click', function() {
            document.getElementById('popup-2fa').style.display = 'none';
        });
    </script>
@endsection
