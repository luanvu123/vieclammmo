@extends('layout')
@section('content')

 <div class="container support-page">
            <div class="support-sections">
                <!-- Support Contact Section -->
                <div class="support-contact">
                    <h2>Liên hệ hỗ trợ</h2>
                    <div class="contact-info">
                        <div class="contact-item">
                            <a href="#" class="faq-link">
                                <i class="fas fa-question-circle"></i>
                                Câu hỏi thường gặp
                            </a>
                        </div>
                        <div class="contact-item">
                            <a href="#" class="facebook-link">
                                <i class="fab fa-facebook"></i>
                                Tạp hóa MMO
                            </a>
                        </div>
                        <div class="contact-item">
                            <a href="#" class="chat-link">
                                <i class="fas fa-comments"></i>
                                Chat với hỗ trợ viên
                            </a>
                        </div>
                        <div class="contact-item">
                            <a href="mailto:support@taphoammo.net" class="email-link">
                                <i class="fas fa-envelope"></i>
                                support@taphoammo.net
                            </a>
                        </div>
                        <div class="contact-item">
                            <span class="time-info">
                                <i class="far fa-clock"></i>
                                Mon-Sat 08:00am - 10:00pm
                            </span>
                        </div>
                    </div>
                    <p class="support-note">Nhân viên hỗ trợ của chúng tôi sẽ cố gắng xử lý khiếu nại và giải quyết thắc mắc của các bạn nhanh nhất có thể.</p>
                </div>

                <!-- Message Form Section -->
                <div class="message-form">
    <h2>Tin nhắn</h2>
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
    <form action="{{ route('support.site') }}" method="POST" class="contact-form">
    @csrf
    <div class="form-row">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="phone">Số điện thoại</label>
            <input type="tel" id="phone" name="phone" required>
        </div>
    </div>

    <div class="form-group">
        <label for="subject">Chủ đề</label>
        <select id="subject" name="subject" class="form-control" required>
            <option value="" disabled selected>Chọn chủ đề</option>
            <option value="Quên Mật khẩu">Quên Mật khẩu</option>
            <option value="Quên 2FA">Quên 2FA</option>
            <option value="Làm sao để mua hàng">Làm sao để mua hàng</option>
            <option value="Hỗ trợ bài viết">Hỗ trợ bài viết</option>
             <option value="Hỗ trợ bán hàng">Hỗ trợ bán hàng</option>
            <option value="Hỗ trợ khác">Hỗ trợ khác</option>
        </select>
    </div>

    <div class="form-group">
        <label for="message">Nội dung</label>
        <textarea id="message" name="message" rows="6" required></textarea>
    </div>

    <button type="submit" class="submit-btn">Gửi</button>
</form>

</div>

            </div>
        </div>

@endsection
