@extends('layout')
@section('content')
    <div class="profile-container">


        <div class="edit-form">
            <div class="form-section">
                <div class="form-row">
                    <div class="form-label">Họ và tên</div>
                    <div class="form-input">
                        <input type="text" placeholder="">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-label">Số điện thoại</div>
                    <div class="form-input">
                        <input type="tel" placeholder="0784784988">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-label">Email</div>
                    <div class="form-input">
                        <input type="email" value="eriajqqvt24060915@vnetwork.io">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-label">Facebook</div>
                    <div class="form-input">
                        <input type="text" placeholder="https://www.facebook.com/profile.php?id=100053766788">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-label"></div>
                    <div class="form-input">
                        <button class="action-btn">Lưu lại</button>
                    </div>
                </div>
            </div>

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
                </div>
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
@endsection
