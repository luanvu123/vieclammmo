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




    <!-- Product Categories Section -->
<section class="product-categories">
    <div class="container">
        <h2 class="section-title">-- DANH SÁCH SẢN PHẨM --</h2>
        <div class="category-grid">
            @php
                // Mảng các class icon
                $iconClasses = ['email-icon', 'software-icon', 'account-icon', 'other-icon'];
            @endphp

            @foreach ($productCategories as $index => $category)
                <div class="category-card">
                    <div class="category-icon {{ $iconClasses[$index % count($iconClasses)] }}">
                        <img src="{{ asset('storage/' . $category->icon) }}" alt="{{ $category->name }}"
                            style="width: 50px; height: 50px;">
                    </div>
                    <h3>{{ $category->name }}</h3>
                    <p>{!! $category->description !!}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>



    <!-- Service Categories Section -->
    <section class="featured-products">
        <div class="container">
            <h2 class="section-title">-- DANH SÁCH DỊCH VỤ --</h2>
            <div class="service-grid">
                @foreach ($serviceCategories as $category)
                    <div class="service-card">
                        <div class="service-icon">
                            <img src="{{ asset('storage/' . $category->icon) }}" alt="{{ $category->name }}"
                                style="width: 50px; height: 50px;">
                        </div>
                        <h3>{{ $category->name }}</h3>
                        <p>{!! $category->description !!}</p>
                    </div>
                @endforeach
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
