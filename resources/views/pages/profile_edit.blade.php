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

            <form action="{{ route('profile.ekyc') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-section">
        <div class="form-section-title">Định danh eKYC</div>

        <div class="form-row">
            <div class="form-label">Ảnh CMND mặt trước</div>
            <div class="form-input">
                <input type="file" name="Front_ID_card_image" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-label">Ảnh CMND mặt sau</div>
            <div class="form-input">
                <input type="file" name="Back_ID_card_image" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-label">Ảnh chân dung</div>
            <div class="form-input">
                <input type="file" name="Portrait_image" required>
                <div class="alert-info">Hình ảnh phải rõ nét và rõ khuôn mặt để xác thực</div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-label"></div>
            <div class="form-input">
                <button type="submit" class="action-btn">Xác thực eKYC</button>
            </div>
        </div>
    </div>
</form>


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
                        @if ($customer->is2Fa)
                            <button class="action-btn-pop enabled" id="disable2faBtn">Tắt</button>
                            <span class="status-badge active">Đang bật</span>
                        @else
                            <button class="action-btn-pop" id="enable2faBtn">Bật</button>
                            <span class="status-badge inactive">Đang tắt</span>
                        @endif
                    </div>
                </div>
            </div>
            <style>
                .tfa-popup-overlay {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background-color: rgba(0, 0, 0, 0.6);
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    z-index: 1000;
                }

                .tfa-popup-container {
                    background-color: white;
                    border-radius: 8px;
                    width: 100%;
                    max-width: 500px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                }

                .tfa-popup-header {
                    padding: 15px 20px;
                    border-bottom: 1px solid #eee;
                }

                .tfa-popup-header h3 {
                    margin: 0;
                    font-size: 18px;
                }

                .tfa-popup-content {
                    padding: 20px;
                }

                .tfa-qr-code {
                    text-align: center;
                    margin: 20px 0;
                }

                .tfa-qr-code img {
                    max-width: 200px;
                    height: auto;
                }

                .tfa-secret-code {
                    font-family: monospace;
                    background-color: #f5f5f5;
                    padding: 10px;
                    border-radius: 4px;
                    text-align: center;
                    font-size: 16px;
                    letter-spacing: 2px;
                    margin: 10px 0;
                }

                .tfa-download {
                    text-align: center;
                    margin: 15px 0;
                }

                .tfa-download-btn {
                    display: inline-block;
                    padding: 8px 15px;
                    background-color: #4CAF50;
                    color: white;
                    text-decoration: none;
                    border-radius: 4px;
                }

                .tfa-download-icon {
                    margin-right: 5px;
                }

                .tfa-warning {
                    color: #f44336;
                    font-size: 14px;
                    margin: 15px 0;
                }

                .tfa-verification {
                    margin: 20px 0;
                }

                .tfa-verification-input {
                    width: 100%;
                    padding: 10px;
                    font-size: 16px;
                    border: 1px solid #ccc;
                    border-radius: 4px;
                    text-align: center;
                    letter-spacing: 5px;
                }

                .tfa-buttons {
                    display: flex;
                    justify-content: space-between;
                    margin-top: 20px;
                }

                .tfa-cancel-btn,
                .tfa-confirm-btn {
                    padding: 10px 20px;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                }

                .tfa-cancel-btn {
                    background-color: #f5f5f5;
                    color: #333;
                }

                .tfa-confirm-btn {
                    background-color: #2196F3;
                    color: white;
                }

                .action-btn-pop.enabled {
                    background-color: #f44336;
                }
            </style>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Get the "Bật" button
                    const enableButton = document.querySelector('.form-input .action-btn-pop');

                    // Create the popup HTML structure
                    const popupHTML = `
    <div id="tfa-popup" class="tfa-popup-overlay" style="display:none;">
        <div class="tfa-popup-container">
            <div class="tfa-popup-header">
                <h3>Bật bảo mật 2 lớp</h3>
            </div>
            <div class="tfa-popup-content">
                <p>Sử dụng app Google Authenticator trên điện thoại của bạn và quét mã này</p>
                <div class="tfa-qr-code">
                    <img id="tfa-qr-code-img" src="" alt="QR Code">
                </div>
                <p>Hoặc sử dụng chuỗi code sau để lấy mã đăng nhập</p>
                <p class="tfa-code">(Có thể lấy mã tại ứng dụng <a href="#">Taphoammo Authenticator</a>)</p>
                <div id="tfa-secret-code" class="tfa-secret-code"></div>
                <div class="tfa-download">
                    <a href="#" id="download-2fa-code" class="tfa-download-btn">
                        <span class="tfa-download-icon">↓</span> Tải code 2fa
                    </a>
                </div>
                <p class="tfa-warning">*Lưu ý: hãy lưu lại chuỗi mã này, nếu mất bạn sẽ không thể đăng nhập vào tài khoản.</p>

                <div class="tfa-verification">
                    <p>Nhập vào mã đăng nhập trước khi xác nhận</p>
                    <input type="text" placeholder="Mã đăng nhập 6 số" maxlength="6" class="tfa-verification-input">
                </div>

                <div class="tfa-buttons">
                    <button class="tfa-cancel-btn">Đóng</button>
                    <button class="tfa-confirm-btn">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>
    `;

                    document.body.insertAdjacentHTML('beforeend', popupHTML);

                    // Get the popup elements
                    const tfaPopup = document.getElementById('tfa-popup');
                    const cancelButton = document.querySelector('.tfa-cancel-btn');
                    const confirmButton = document.querySelector('.tfa-confirm-btn');
                    const qrCodeImg = document.getElementById('tfa-qr-code-img');
                    const secretCodeElement = document.getElementById('tfa-secret-code');
                    const downloadButton = document.getElementById('download-2fa-code');

                    // Biến lưu trữ secret key
                    let secretKey = '';

                    // Add click event listener to the "Bật" button
                    if (enableButton) {
                        enableButton.addEventListener('click', function(e) {
                            e.preventDefault();

                            // Gọi API để tạo secret key
                            fetch('/profile/2fa/generate', {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                            .getAttribute('content'),
                                        'Accept': 'application/json',
                                        'Content-Type': 'application/json'
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        // Hiển thị thông tin 2FA
                                        secretKey = data.secret;
                                        secretCodeElement.textContent = secretKey;

                                        // Tạo QR code
                                        qrCodeImg.src =
                                            'https://chart.googleapis.com/chart?chs=200x200&chld=M|0&cht=qr&chl=' +
                                            encodeURIComponent(data.qrCodeUrl);

                                        // Hiển thị popup
                                        tfaPopup.style.display = 'flex';

                                        // Thiết lập tải xuống secret key
                                        downloadButton.setAttribute('href', 'data:text/plain;charset=utf-8,' +
                                            encodeURIComponent(secretKey));
                                        downloadButton.setAttribute('download', 'your-2fa-secret.txt');
                                    } else {
                                        alert(data.message);
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    alert('Đã xảy ra lỗi khi tạo secret key');
                                });
                        });
                    }

                    // Add click event listener to the "Đóng" button
                    if (cancelButton) {
                        cancelButton.addEventListener('click', function() {
                            tfaPopup.style.display = 'none';
                        });
                    }

                    // Add click event listener to the "Xác nhận" button
                    if (confirmButton) {
                        confirmButton.addEventListener('click', function() {
                            const verificationCode = document.querySelector('.tfa-verification-input').value;

                            if (!verificationCode || verificationCode.length !== 6) {
                                alert('Vui lòng nhập mã xác nhận 6 số!');
                                return;
                            }

                            // Gọi API để bật 2FA
                            fetch('/profile/2fa/enable', {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                            .getAttribute('content'),
                                        'Accept': 'application/json',
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        verification_code: verificationCode
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        alert(data.message);
                                        tfaPopup.style.display = 'none';

                                        // Có thể cập nhật UI để hiển thị trạng thái 2FA đã bật
                                        if (enableButton) {
                                            enableButton.textContent = 'Tắt';
                                            enableButton.classList.add('enabled');
                                        }

                                        // Reload trang
                                        window.location.reload();
                                    } else {
                                        alert(data.message);
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    alert('Đã xảy ra lỗi khi bật 2FA');
                                });
                        });
                    }

                    // Close the popup when clicking outside of it
                    tfaPopup.addEventListener('click', function(e) {
                        if (e.target === tfaPopup) {
                            tfaPopup.style.display = 'none';
                        }
                    });
                });
            </script>




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
    <div id="disable-tfa-popup" class="tfa-popup-overlay" style="display:none;">
        <div class="tfa-popup-container">
            <div class="tfa-popup-header">
                <h3>Tắt bảo mật 2 lớp</h3>
            </div>
            <div class="tfa-popup-content">
                <p>Để tắt bảo mật 2 lớp, vui lòng nhập mã xác thực từ ứng dụng Authenticator của bạn</p>

                <div class="tfa-verification">
                    <input type="text" placeholder="Mã đăng nhập 6 số" maxlength="6"
                        class="tfa-verification-input-disable">
                </div>

                <div class="tfa-buttons">
                    <button class="tfa-cancel-btn-disable">Đóng</button>
                    <button class="tfa-confirm-btn-disable">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Thêm vào JavaScript hiện tại
        const disableButton = document.getElementById('disable2faBtn');
        const disableTfaPopup = document.getElementById('disable-tfa-popup');
        const cancelDisableButton = document.querySelector('.tfa-cancel-btn-disable');
        const confirmDisableButton = document.querySelector('.tfa-confirm-btn-disable');

        if (disableButton) {
            disableButton.addEventListener('click', function(e) {
                e.preventDefault();
                disableTfaPopup.style.display = 'flex';
            });
        }

        if (cancelDisableButton) {
            cancelDisableButton.addEventListener('click', function() {
                disableTfaPopup.style.display = 'none';
            });
        }

        if (confirmDisableButton) {
            confirmDisableButton.addEventListener('click', function() {
                const verificationCode = document.querySelector('.tfa-verification-input-disable').value;

                if (!verificationCode || verificationCode.length !== 6) {
                    alert('Vui lòng nhập mã xác nhận 6 số!');
                    return;
                }

                // Gọi API để tắt 2FA
                fetch('/profile/2fa/disable', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content'),
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            verification_code: verificationCode
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                            disableTfaPopup.style.display = 'none';

                            // Cập nhật UI
                            if (disableButton) {
                                disableButton.textContent = 'Bật';
                                disableButton.classList.remove('enabled');
                                disableButton.id = 'enable2faBtn';
                            }

                            // Reload trang
                            window.location.reload();
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Đã xảy ra lỗi khi tắt 2FA');
                    });
            });
        }

        disableTfaPopup.addEventListener('click', function(e) {
            if (e.target === disableTfaPopup) {
                disableTfaPopup.style.display = 'none';
            }
        });
    </script>
@endsection
