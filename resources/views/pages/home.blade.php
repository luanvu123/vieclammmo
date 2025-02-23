@extends('layout')
@section('content')
    <div class="banner"
        style="background-image: url('{{ asset('img/finder.jpg') }}'); background-size: cover; background-position: center;">
        <div class="container">
            <div class="banner-content">
                <div class="alert-message" id="alertMessage">
                    Tạp Hóa MMO - Sàn thương mại điện tử sản phẩm số phục vụ kiếm tiền online. Mọi giao dịch trên trang đều
                    hoàn toàn tự động và được giữ tiền 3 ngày
                </div>
                <div class="search-section">
                    <div class="search-container">
                        <div class="search-dropdown">
                            <select>
                                <option>Tùy chọn tìm kiếm</option>
                                <option>Sản phẩm</option>
                                <option>Người bán</option>
                            </select>
                        </div>
                        <div class="search-input">
                            <input type="text" placeholder="Tìm gian hàng hoặc người bán">
                            <button class="search-btn">Tìm kiếm</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .banner {
            padding: 30px 0;
            position: relative;
            color: #fff;
        }

        .banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }

        .banner-content {
            position: relative;
            z-index: 2;
        }

        .alert-message {
            background-color: rgba(255, 87, 34, 0.8);
            padding: 12px 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
            animation: alertPulse 2s infinite;
        }

        @keyframes alertPulse {
            0% {
                background-color: rgba(255, 87, 34, 0.8);
            }

            50% {
                background-color: rgba(255, 160, 0, 0.8);
            }

            100% {
                background-color: rgba(255, 87, 34, 0.8);
            }
        }

        .search-container {
            display: flex;
            background-color: #fff;
            border-radius: 5px;
            overflow: hidden;
        }

        .search-dropdown select {
            padding: 12px 15px;
            border: none;
            background-color: #f5f5f5;
            font-weight: bold;
        }

        .search-input {
            display: flex;
            flex: 1;
        }

        .search-input input {
            flex: 1;
            padding: 12px 15px;
            border: none;
            outline: none;
        }

        .search-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 0 25px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .search-btn:hover {
            background-color: #388E3C;
        }
    </style>

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

    <!-- Product Categories Section -->
    <section class="product-categories">
        <div class="container">
            <h2 class="section-title">-- DANH SÁCH SẢN PHẨM --</h2>

            <div class="category-grid">
                <div class="category-card">
                    <div class="category-icon email-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3>Email</h3>
                    <p>Gmail, yahoo mail, hot mail... và nhiều hơn thế nữa</p>
                </div>

                <div class="category-card">
                    <div class="category-icon software-icon">
                        <i class="fas fa-compact-disc"></i>
                    </div>
                    <h3>Phần mềm</h3>
                    <p>Các phần mềm chuyên dụng cho kiếm tiền online từ đồng code vụ tin</p>
                </div>

                <div class="category-card">
                    <div class="category-icon account-icon">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <h3>Tài khoản</h3>
                    <p>Fb, BM, key window, kaspersky...</p>
                </div>

                <div class="category-card">
                    <div class="category-icon other-icon">
                        <i class="fas fa-box"></i>
                    </div>
                    <h3>Khác</h3>
                    <p>Các sản phẩm số khác</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="featured-products">
        <div class="container">
            <h2 class="section-title">-- DANH SÁCH DỊCH VỤ --</h2>

            <div class="service-grid">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Tăng tương tác</h3>
                    <p>Tăng like, view, share, comment... cho sản phẩm của bạn</p>
                </div>

                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <h3>Dịch vụ phần mềm</h3>
                    <p>Dịch vụ code tool MMO, đồ họa, video... và các dịch vụ liên quan</p>
                </div>

                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-link"></i>
                    </div>
                    <h3>Blockchain</h3>
                    <p>Dịch vụ tiền ảo, NFT, coinlist... và các dịch vụ blockchain khác</p>
                </div>

                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <h3>Dịch vụ khác</h3>
                    <p>Các dịch vụ MMO phổ biến khác hiện nay</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Recommended Products -->
    <section class="recommended-products">
        <div class="container">
            <h2 class="section-heading">Lời tắt</h2>

            <div class="product-carousel">
                <div class="carousel-nav prev"><i class="fas fa-chevron-left"></i></div>

                <div class="product-slides">
                    <div class="product-card">
                        <div class="product-tag">Sản phẩm đã mua</div>
                        <div class="product-image">
                            <img src="/api/placeholder/200/150" alt="Telegram">
                        </div>
                        <div class="product-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <span>2902 Reviews</span>
                        </div>
                        <h3 class="product-title">Telegram</h3>
                        <p class="product-desc">TDATA+SESSION, Reg Phone Thái, FULL INFO</p>
                        <div class="product-price">24.980 đ - 77.777 đ</div>
                        <div class="product-seller">
                            <span>Người bán:</span>
                            <a href="#">hieule9898</a>
                        </div>
                    </div>

                    <div class="product-card">
                        <div class="product-tag">Có thể quan tâm</div>
                        <div class="product-image">
                            <img src="/api/placeholder/200/150" alt="Dịch vụ tiền ảo">
                        </div>
                        <div class="product-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <span>183 Reviews</span>
                        </div>
                        <h3 class="product-title">Dịch vụ tiền ảo</h3>
                        <p class="product-desc">Liên hệ để kéo Tele xem danh sách dưới mô tả</p>
                        <div class="product-price">1.500 đ - 800.000 đ</div>
                        <div class="product-seller">
                            <span>Người bán:</span>
                            <a href="#">anthea1604</a>
                        </div>
                    </div>

                    <div class="product-card">
                        <div class="product-tag">Có thể quan tâm</div>
                        <div class="product-image">
                            <img src="/api/placeholder/200/150" alt="YouTube">
                        </div>
                        <div class="product-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <span>3 Reviews</span>
                        </div>
                        <h3 class="product-title">Dịch vụ YouTube Chính</h3>
                        <p class="product-desc">Chỉ giá rẻ 1,3,6,12 tháng</p>
                        <div class="product-price">20.000 đ - 179.000 đ</div>
                        <div class="product-seller">
                            <span>Người bán:</span>
                            <a href="#">graysen_sb64wa</a>
                        </div>
                    </div>
                </div>

                <div class="carousel-nav next"><i class="fas fa-chevron-right"></i></div>
            </div>
        </div>
    </section>

    <!-- Featured Sellers -->
    <section class="featured-sellers">
        <div class="container">
            <div class="sellers-grid">
                <div class="seller-card facebook">
                    <div class="seller-logo">
                        <img src="/api/placeholder/150/150" alt="Facebook">
                    </div>
                    <div class="seller-info">
                        <div class="inventory">Tồn kho: 1183</div>
                        <div class="price-range">56.500 đ - 149.999 đ</div>
                        <div class="seller-tag">FACEBOOK VIỆT</div>
                        <div class="seller-desc">CÓ 1000-5000 BẠN BÈ TẠO 2005-2022</div>
                        <div class="seller-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                            <span>1164 Reviews</span>
                        </div>
                        <div class="seller-name">
                            <span>Người bán:</span> <a href="#">shopbanreutin</a>
                        </div>
                        <a href="#" class="support-button">Tải trợ</a>
                    </div>
                </div>

                <div class="seller-card proxy">
                    <div class="seller-logo">
                        <img src="/api/placeholder/150/150" alt="WW Proxy">
                    </div>
                    <div class="seller-info">
                        <div class="inventory">Tồn kho: 3000</div>
                        <div class="price-range">2.000 đ - 15.000 đ</div>
                        <div class="seller-tag">WW Proxy - IP đắn cư Việt Nam</div>
                        <div class="seller-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <span>405 Reviews</span>
                        </div>
                        <div class="seller-name">
                            <span>Người bán:</span> <a href="#">wwproxy</a>
                        </div>
                        <a href="#" class="support-button">Tải trợ</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
