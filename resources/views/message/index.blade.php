@extends('layout')

@section('content')
<style>


    .message-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        border-bottom: 1px solid #e0e0e0;
    }

    .message-header h2 {
        margin: 0;
        font-size: 1.5rem;
        color: #333;
    }

    .message-actions {
        display: flex;
        align-items: center;
    }

    .message-notification {
        margin-right: 15px;
        font-size: 0.9rem;
        color: #555;
    }

    .back-button {
        background: none;
        border: none;
        color: #007bff;
        cursor: pointer;
        font-size: 1.2rem;
    }

    .message-content {
        display: flex;
        height: 100%;
    }

    .message-list {
        width: 35%;
        border-right: 1px solid #e0e0e0;
        overflow-y: auto;
    }

    .message-item {
        display: flex;
        padding: 15px;
        border-bottom: 1px solid #f0f0f0;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .message-item:hover {
        background-color: #f8f9fa;
    }

    .message-item.active {
        background-color: #e7f3ff;
    }

    .message-item.system-message {
        background-color: #fff8e6;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        overflow: hidden;
        margin-right: 10px;
    }

    .user-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .user-avatar.system {
        background-color: #ff5722;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .message-info {
        flex: 1;
    }

    .message-user {
        display: flex;
        justify-content: space-between;
        margin-bottom: 5px;
    }

    .username {
        font-weight: 500;
        color: #333;
    }

    .message-date {
        font-size: 0.8rem;
        color: #777;
    }

    .message-preview {
        font-size: 0.9rem;
        color: #666;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .message-detail {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .chat-header {
        padding: 15px;
        border-bottom: 1px solid #e0e0e0;
    }

    .chat-user {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .user-status {
        font-weight: 500;
        font-size: 1.1rem;
        margin-right: 10px;
    }

    .online-status {
        font-size: 0.8rem;
        color: #777;
    }

    .chat-warning {
        background-color: #fff3cd;
        color: #856404;
        padding: 8px 12px;
        border-radius: 5px;
        font-size: 0.85rem;
    }

    .chat-messages {
        flex: 1;
        padding: 15px;
        overflow-y: auto;
        background-color: #f5f5f5;
    }

    .system-alert {
        display: flex;
        margin-bottom: 20px;
    }

    .system-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: #ff5722;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        flex-shrink: 0;
    }

    .system-icon img {
        width: 30px;
        height: 30px;
        object-fit: cover;
    }

    .system-message-content {
        background-color: #fff;
        padding: 15px;
        border-radius: 0 15px 15px 15px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        max-width: 80%;
        position: relative;
    }

    .system-message-content p {
        margin: 0 0 10px 0;
        font-size: 0.95rem;
        line-height: 1.5;
        color: #333;
    }

    .message-time {
        font-size: 0.75rem;
        color: #888;
        text-align: right;
        display: block;
    }

    .chat-input {
        display: flex;
        align-items: center;
        padding: 10px 15px;
        border-top: 1px solid #e0e0e0;
        background-color: #fff;
    }

    .upload-btn, .emoji-btn, .send-btn {
        background: none;
        border: none;
        color: #555;
        font-size: 1.2rem;
        cursor: pointer;
        margin: 0 5px;
        transition: color 0.2s;
    }

    .upload-btn:hover, .emoji-btn:hover {
        color: #007bff;
    }

    .send-btn {
        color: #007bff;
    }

    .send-btn:hover {
        color: #0056b3;
    }

    .message-input {
        flex: 1;
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 20px;
        outline: none;
        margin: 0 10px;
    }

    .message-input:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .text-danger {
        color: #dc3545;
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
        .message-content {
            flex-direction: column;
        }

        .message-list {
            width: 100%;
            height: 40%;
            border-right: none;
            border-bottom: 1px solid #e0e0e0;
        }

        .message-detail {
            height: 60%;
        }
    }
</style>
<div class="post-container">
    <div class="message-header">
        <h2>Tin nhắn</h2>
        <div class="message-actions">
            <span class="message-notification">Gần đây <i class="fas fa-volume-up"></i></span>
            <button class="back-button"><i class="fas fa-chevron-left"></i></button>
        </div>
    </div>

    <div class="message-content">
        <div class="message-list">
            <!-- Danh sách người nhắn tin -->
            <div class="message-item active">
                <div class="user-avatar">
                    <img src="{{ asset('img/user-icon.png') }}" alt="User">
                </div>
                <div class="message-info">
                    <div class="message-user">
                        <span class="username">arpjwashleyclaudiacook</span>
                        <span class="message-date">28/2/2025</span>
                    </div>
                    <div class="message-preview">CẢNH BÁO! Các SHOP lưu ý không đư...</div>
                </div>
            </div>

            <div class="message-item system-message">
                <div class="user-avatar system">
                    <img src="{{ asset('img/system-icon.png') }}" alt="System">
                </div>
                <div class="message-info">
                    <div class="message-user">
                        <span class="username">system_bot <i class="fas fa-circle text-danger"></i></span>
                        <span class="message-date">24/2/2025</span>
                    </div>
                    <div class="message-preview">THÔNG BÁO QUAN TRỌNG – HẠN CUỐI C...</div>
                </div>
            </div>

            <div class="message-item">
                <div class="user-avatar">
                    <img src="{{ asset('img/user-icon.png') }}" alt="User">
                </div>
                <div class="message-info">
                    <div class="message-user">
                        <span class="username">0862610104</span>
                        <span class="message-date">28/11/2024</span>
                    </div>
                    <div class="message-preview">alo nt lại zalo tui vs quên zalo ...</div>
                </div>
            </div>

            <div class="message-item">
                <div class="user-avatar">
                    <img src="{{ asset('img/user-icon.png') }}" alt="User">
                </div>
                <div class="message-info">
                    <div class="message-user">
                        <span class="username">ricene290301</span>
                        <span class="message-date">28/11/2024</span>
                    </div>
                    <div class="message-preview">uci đổi mình vào</div>
                </div>
            </div>

            <div class="message-item">
                <div class="user-avatar">
                    <img src="{{ asset('img/user-icon.png') }}" alt="User">
                </div>
                <div class="message-info">
                    <div class="message-user">
                        <span class="username">izaiah_ptxtqr</span>
                        <span class="message-date">25/11/2024</span>
                    </div>
                    <div class="message-preview">20</div>
                </div>
            </div>

            <div class="message-item">
                <div class="user-avatar">
                    <img src="{{ asset('img/user-icon.png') }}" alt="User">
                </div>
                <div class="message-info">
                    <div class="message-user">
                        <span class="username">tate_pnimdd</span>
                        <span class="message-date">25/11/2024</span>
                    </div>
                    <div class="message-preview">Thì gửi lại list mình</div>
                </div>
            </div>

            <div class="message-item">
                <div class="user-avatar">
                    <img src="{{ asset('img/user-icon.png') }}" alt="User">
                </div>
                <div class="message-info">
                    <div class="message-user">
                        <span class="username">suzuki8668</span>
                        <span class="message-date">24/11/2024</span>
                    </div>
                    <div class="message-preview">bác tiền tay đánh giá giúp mình i...</div>
                </div>
            </div>

            <div class="message-item">
                <div class="user-avatar">
                    <img src="{{ asset('img/user-icon.png') }}" alt="User">
                </div>
                <div class="message-info">
                    <div class="message-user">
                        <span class="username">adam6789</span>
                        <span class="message-date">23/11/2024</span>
                    </div>
                    <div class="message-preview">100094699182246 100094431090472 t...</div>
                </div>
            </div>

            <div class="message-item">
                <div class="user-avatar">
                    <img src="{{ asset('img/user-icon.png') }}" alt="User">
                </div>
                <div class="message-info">
                    <div class="message-user">
                        <span class="username">damien_zc77wa</span>
                        <span class="message-date">23/11/2024</span>
                    </div>
                    <div class="message-preview">k bác</div>
                </div>
            </div>

            <div class="message-item">
                <div class="user-avatar">
                    <img src="{{ asset('img/user-icon.png') }}" alt="User">
                </div>
                <div class="message-info">
                    <div class="message-user">
                        <span class="username">meomeobeo</span>
                        <span class="message-date">22/11/2024</span>
                    </div>
                    <div class="message-preview">bạn cần hỗ trợ gì</div>
                </div>
            </div>

            <div class="message-item">
                <div class="user-avatar">
                    <img src="{{ asset('img/user-icon.png') }}" alt="User">
                </div>
                <div class="message-info">
                    <div class="message-user">
                        <span class="username">kane_liipfg</span>
                        <span class="message-date">21/11/2024</span>
                    </div>
                    <div class="message-preview">mai bác đăng nhập lại là dc</div>
                </div>
            </div>
        </div>

        <div class="message-detail">
            <!-- Chi tiết tin nhắn -->
            <div class="chat-header">
                <div class="chat-user">
                    <span class="user-status">@system_bot <i class="fas fa-circle text-danger"></i></span>
                    <span class="online-status">Online 8/25 ngày trước</span>
                </div>
                <div class="chat-warning">
                    Xin hãy cảnh giác với giao dịch không được bảo hiểm bên ngoài chat!
                </div>
            </div>

            <div class="chat-messages">
                <div class="system-alert">
                    <div class="system-icon">
                        <img src="{{ asset('img/system-icon.png') }}" alt="System">
                    </div>
                    <div class="system-message-content">
                        <p>THÔNG BÁO QUAN TRỌNG – HẠN CUỐI CÙNG eKYC Kính gửi Quý Shop, Nhằm đảm bảo tính minh bạch và an toàn trong hoạt động kinh doanh trên Tạp Hóa MMO, Quý Shop vui lòng hoàn thành xác minh eKYC trước ngày 01/03/2025. LƯU Ý QUAN TRỌNG -Shop không hoàn tất eKYC trước 01/03/^025 sẽ bị tạm ngừng hoạt động (off gian hàng). -Việc xác minh KYC giúp Shop duy trì hoạt động, nhận thanh toán và đảm bảo quyền lợi. Cách thực hiện eKYC: Truy cập https://taphoammo.net/profile.html và làm theo hướng dẫn. Mọi thắc mắc, Quý Shop vui lòng liên hệ qua Website taphoammo.net hoặc Fanpage Tạp Hóa MMO để được giải đáp. Hãy hoàn thành sớm để không ảnh hưởng đến việc kinh doanh của Shop! Cảm ơn sự hợp tác của Quý Shop. Trân trọng,Sàn Thương Mại Điện Tử Tạp Hóa MMO</p>
                        <span class="message-time">13:20 - 24/02</span>
                    </div>
                </div>

                <div class="system-alert">
                    <div class="system-icon">
                        <img src="{{ asset('img/system-icon.png') }}" alt="System">
                    </div>
                    <div class="system-message-content">
                        <p>Thông báo đến các shop tham gia đấu giá lúc 20h 16/02/^025. Số tiền đấu giá sẽ được hoàn lại tiền. Đấu giá sẽ diễn ra lại vào lúc 12h 17/02/^025. Mong các shop thông cảm đối với sự cố không mong muốn xảy ra. Trân trọng !</p>
                        <span class="message-time">20:52 - 07/02</span>
                    </div>
                </div>

                <div class="system-alert">
                    <div class="system-icon">
                        <img src="{{ asset('img/system-icon.png') }}" alt="System">
                    </div>
                    <div class="system-message-content">
                        <p>Đấu giá sẽ diễn ra lại vào lúc 12h30 17/02/^025. Mong các shop thông cảm đối với sự cố không mong muốn xảy ra. Trân trọng !</p>
                        <span class="message-time">21:45 - 16/02</span>
                    </div>
                </div>

                <div class="system-alert">
                    <div class="system-icon">
                        <img src="{{ asset('img/system-icon.png') }}" alt="System">
                    </div>
                    <div class="system-message-content">
                        <p>THÔNG BÁO QUAN TRỌNG – HẠN CUỐI CÙNG eKYC Kính gửi Quý Shop, Nhằm đảm bảo tính minh bạch và an toàn trong hoạt động kinh doanh trên Tạp Hóa MMO, Quý Shop vui lòng hoàn thành xác minh eKYC trước ngày 01/03/2025. LƯU Ý QUAN TRỌNG -Shop không hoàn tất eKYC trước 01/03/^025 sẽ bị tạm ngừng hoạt động (off gian hàng). -Việc xác minh KYC giúp Shop duy trì hoạt động, nhận thanh toán và đảm bảo quyền lợi. Cách thực hiện eKYC: Truy cập https://taphoammo.net/profile.html và làm theo hướng dẫn. Mọi thắc mắc, Quý Shop vui lòng liên hệ qua Website taphoammo.net hoặc Fanpage Tạp Hóa MMO để được giải đáp. Hãy hoàn thành sớm để không ảnh hưởng đến việc kinh doanh của Shop! Cảm ơn sự hợp tác của Quý Shop. Trân trọng,Sàn Thương Mại Điện Tử Tạp Hóa MMO</p>
                        <span class="message-time">12:16 - 17/02</span>
                    </div>
                </div>
            </div>

            <div class="chat-input">
                <button class="upload-btn"><i class="fas fa-paperclip"></i></button>
                <button class="emoji-btn"><i class="far fa-smile"></i></button>
                <input type="text" placeholder="Type a message" class="message-input">
                <button class="send-btn"><i class="fas fa-paper-plane"></i></button>
            </div>
        </div>
    </div>
</div>
<script>
    // Toggle active class for message items
    document.querySelectorAll('.message-item').forEach(item => {
        item.addEventListener('click', () => {
            document.querySelectorAll('.message-item').forEach(el => {
                el.classList.remove('active');
            });
            item.classList.add('active');
        });
    });

    // Toggle user dropdown
    function toggleDropdown() {
        document.getElementById('userDropdown').classList.toggle('show');
    }

    // Close dropdown when clicking outside
    window.addEventListener('click', function(event) {
        if (!event.target.matches('.user-icon') && !event.target.closest('.user-icon')) {
            const dropdown = document.getElementById('userDropdown');
            if (dropdown.classList.contains('show')) {
                dropdown.classList.remove('show');
            }
        }
    });
</script>
@endsection
