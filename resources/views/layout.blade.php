<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TapHoa MMO - Sàn thương mại điện tử</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>
    <!-- Header -->
    <header class="main-header">
        <div class="support-bar">
            <div class="container">
                <div class="support-info">
                    <span><i class="fas fa-headset"></i> Hỗ trợ trực tuyến</span>
                    <span><i class="fas fa-leaf"></i> Tạp hóa MMO</span>
                    <span><i class="fas fa-envelope"></i> support@taphoammo.net</span>
                    <span><i class="far fa-clock"></i> 08:00am - 10:00pm</span>
                </div>
                <div class="language-selector">
                    <span>Ngôn ngữ: VI <i class="fas fa-chevron-down"></i></span>
                </div>
            </div>
        </div>

        <div class="main-nav container">
            <a href="index.html" class="logo">
                <h1>TapHoa<span class="highlight">MMO</span></h1>
            </a>

            <nav class="menu">
                <ul>
                    <li class="dropdown">
                        <a href="{{ route('category.site') }}">Sản phẩm</a>
                        <ul class="submenu">
                            @if (isset($layout_categories['Sản phẩm']))
                                @foreach ($layout_categories['Sản phẩm'] as $category)
                                    <li><a href="#">{{ $category->name }}</a></li>
                                @endforeach
                            @else
                                <li><a href="#">Không có sản phẩm</a></li>
                            @endif
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#">Dịch vụ</a>
                        <ul class="submenu">
                            @if (isset($layout_categories['Dịch vụ']))
                                @foreach ($layout_categories['Dịch vụ'] as $category)
                                    <li><a href="#">{{ $category->name }}</a></li>
                                @endforeach
                            @else
                                <li><a href="#">Không có dịch vụ</a></li>
                            @endif
                        </ul>
                    </li>

                    <li><a href="{{ route('support.site') }}">Hỗ trợ</a></li>
                    <li><a href="#">Chia sẻ</a></li>
                    <li><a href="#">Công cụ</a></li>
                    <li><a href="#">FAQs</a></li>
                    <li><a href="#">Nạp tiền</a></li>
                </ul>
            </nav>


           @if(Auth::guard('customer')->check())
    <!-- Nếu đã đăng nhập -->
    <div class="user-actions">
        <div class="balance">56.407 VND</div>
        <a href="#" class="cart-icon"><i class="fas fa-shopping-cart"></i><span class="badge">2</span></a>
        <a href="#" class="notifications-icon"><i class="fas fa-bell"></i><span class="badge">0</span></a>
        <button class="mobile-menu-toggle" id="menuToggle">
            <i class="fas fa-bars"></i>
        </button>
    </div>
    <div class="user-menu">
        <div class="user-icon" onclick="toggleDropdown()">
            <div class="user-avatar">
                <img src="{{ asset('img/user-icon.png') }}" alt="User" />
            </div>
        </div>
        <div class="dropdown-content" id="userDropdown">
            <div class="user-icon">
                <div class="user-avatar">
                    <img src="{{ asset('img/user-icon.png') }}" alt="User" />
                </div>
                <span>{{ Auth::guard('customer')->user()->username }}</span>
            </div>
            <a href="{{ route('profile.site') }}">Thông tin tài khoản</a>
            <a href="#">Đơn hàng đã mua</a>
            <a href="#">Gian hàng yêu thích</a>
            <a href="#">Lịch sử thanh toán</a>
            <a href="#">Reseller</a>
            <a href="#">Quản lý nội dung</a>
            <a href="#">Đổi mật khẩu</a>
            <div class="divider"></div>
            <a href="{{ route('dashboard.site') }}">Quản lý cửa hàng</a>
            <div class="divider"></div>
            <a href="#"
               onclick="event.preventDefault();
                        if (confirm('Bạn có muốn đăng xuất?')) {
                            document.getElementById('logout-form').submit();
                        }">
                Thoát
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
@else
    <!-- Nếu chưa đăng nhập -->
    <a href="{{ route('login.customer') }}" class="btn btn-success" style="color: white;">
        Đăng nhập
    </a>
@endif



        </div>
    </header>

    <!-- Main Content Area -->
    <main class="main-content">
        @yield('content')
        <div id="page-content"></div>
    </main>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="container">
            <div class="footer-section">
                <h3>Liên hệ</h3>
                <ul>
                    <li><i class="fab fa-facebook"></i> <a href="#">Tạp hóa MMO</a></li>
                    <li><i class="fas fa-comment"></i> <a href="#">Chat với hỗ trợ viên</a></li>
                    <li><i class="fas fa-envelope"></i> <a href="mailto:support@taphoammo.net">support@taphoammo.net</a>
                    </li>
                    <li><i class="far fa-clock"></i> Mon-Sat 08:00am - 10:00pm</li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>Thông tin</h3>
                <ul>
                    <li><a href="#">Mọi ứng dụng nhắm kết nối, trao đổi, mua trong cộng đồng kiếm tiền online.</a>
                    </li>
                    <li><a href="#">Thanh toán tự động, nhận hàng ngay tức thì.</a></li>
                    <li><a href="#">Câu hỏi thường gặp</a></li>
                    <li><a href="#">Điều khoản sử dụng</a></li>
                </ul>
                <div class="social-links">
                    <a href="#"><i class="fas fa-rss"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                </div>
            </div>

            <div class="footer-section">
                <h3>Đăng ký bán hàng</h3>
                <p>Tạo một gian hàng của bạn trên trang chúng tôi. Đội ngũ hỗ trợ sẽ liên lạc để giúp bạn tối ưu khả
                    năng bán hàng.</p>
                <a href="#" class="register-btn">Đăng ký ngay</a>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <p>&copy; 2024 TapHoa MMO. All Rights Reserved.</p>
            </div>
        </div>
    </footer>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const dropdowns = document.querySelectorAll(".menu .dropdown > a");

            dropdowns.forEach(dropdown => {
                dropdown.addEventListener("click", function(event) {
                    event.preventDefault();

                    // Đóng tất cả các menu trước khi mở menu mới
                    document.querySelectorAll(".menu .dropdown").forEach(item => {
                        if (item !== this.parentElement) {
                            item.classList.remove("active");
                        }
                    });

                    // Toggle hiển thị menu con
                    this.parentElement.classList.toggle("active");
                });
            });

            // Đóng menu khi click ra ngoài
            document.addEventListener("click", function(event) {
                if (!event.target.closest(".menu")) {
                    document.querySelectorAll(".menu .dropdown").forEach(item => {
                        item.classList.remove("active");
                    });
                }
            });
        });
    </script>
    <script>
        function toggleDropdown() {
            document.getElementById("userDropdown").classList.toggle("show");
        }

        // Close dropdown when clicking outside
        window.onclick = function(event) {
            if (!event.target.closest('.user-menu')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif
    </script>

</body>

</html>
