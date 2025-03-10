<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TapHoa MMO - Sàn thương mại điện tử</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Slick Slider CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick-theme.css" />

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
            <a href="{{ route('/') }}" class="logo">
                <h1>TapHoa<span class="highlight">MMO</span></h1>
            </a>

            <nav class="menu">
                <ul>
                    <li class="dropdown">
                        <a href="#">Sản phẩm</a>
                        <ul class="submenu">
                            @if (isset($layout_categories['Sản phẩm']))
                                @foreach ($layout_categories['Sản phẩm'] as $category)
                                    <li><a
                                            href="{{ route('category.products', $category->slug) }}">{{ $category->name }}</a>
                                    </li>
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
                                    <li><a
                                            href="{{ route('category.products', $category->slug) }}">{{ $category->name }}</a>
                                    </li>
                                @endforeach
                            @else
                                <li><a href="#">Không có dịch vụ</a></li>
                            @endif
                        </ul>
                    </li>

                    <li><a href="{{ route('support.site') }}">Hỗ trợ</a></li>
                    <li><a href="{{ route('post.site') }}">Chia sẻ</a></li>
                    <li><a href="https://2fa.live/">Công cụ</a></li>
                    <li><a href="{{ route('faqs') }}">FAQs</a></li>
                    <li><a href="{{ route('checkout') }}">Nạp tiền</a></li>
                </ul>
            </nav>


            @if (Auth::guard('customer')->check())
                <!-- Nếu đã đăng nhập -->
                <div class="user-actions">
                    <div class="balance">
                        {{ number_format(Auth::guard('customer')->user()->Balance, 0, ',', '.') }} VND
                    </div>
                    <a href="{{ route('messages.create', ['customerId' => Auth::guard('customer')->id()]) }}" class="notifications-icon"><i class="fas fa-message"></i><span
                            class="badge">0</span></a>
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
                            <span>{{ Auth::guard('customer')->user()->name }}</span>

                        </div>

                        <a href="{{ route('profile.site') }}">Thông tin tài khoản</a>
                        <a href="{{route('orders.index')}}">Đơn hàng đã mua</a>
                        <a href="{{ route('wishlist.index') }}">Gian hàng yêu thích</a>
                        <a href="#">Lịch sử thanh toán</a>
                        <a href="{{ route('posts.create') }}">Quản lý nội dung</a>
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
                        <form id="logout-form" action="{{ route('logout.customer') }}" method="POST"
                            style="display: none;">
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
                    <li><a href="#">Mọi ứng dụng nhắm kết nối, trao đổi, mua trong cộng đồng kiếm tiền
                            online.</a>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alertText = document.getElementById('alertMessage').textContent;
            const alertElement = document.getElementById('alertMessage');

            // Hiệu ứng chạy text
            let position = 0;
            const speed = 50; // milliseconds

            function scrollText() {
                let shiftedText = alertText.substring(position) + ' — ' + alertText.substring(0, position);
                alertElement.textContent = shiftedText;
                position++;
                if (position > alertText.length) {
                    position = 0;
                }
                setTimeout(scrollText, speed);
            }

            scrollText();
        });
    </script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">

    <!-- Include DataTables JavaScript -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#user-table').DataTable();
        });
    </script>
    <script src="{{ asset('backend_admin/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('description');
    </script>



    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick-theme.css" />


    <!-- Thêm JS của Slick -->
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.product-slides').slick({
                slidesToShow: 3, // Hiển thị 3 sản phẩm cùng lúc
                slidesToScroll: 3, // Mỗi lần lướt sẽ cuộn 3 sản phẩm
                infinite: true,
                dots: true,
                arrows: true,
                prevArrow: $('.carousel-nav.prev'),
                nextArrow: $('.carousel-nav.next'),
                responsive: [{
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.slider').slick({
                slidesToShow: 4, // Số sản phẩm hiển thị cùng lúc
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 3000,
                arrows: true,
                prevArrow: '<button class="nav-button prev">◀</button>',
                nextArrow: '<button class="nav-button next">▶</button>',
                responsive: [{
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1
                        }
                    }
                ]
            });
        });
    </script>

</body>

</html>
