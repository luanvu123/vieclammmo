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
                <form action="{{ route('site.search') }}" method="GET" id="searchForm">
                    <div class="search-section">
                        <div class="search-container">

                            <div class="search-dropdown">
                                <select name="searchType">
                                    <option value="Sản phẩm">Sản phẩm</option>
                                    <option value="Người bán">Người bán</option>
                                </select>
                            </div>
                            <div class="search-input">
                                <input type="text" name="keyword" placeholder="Tìm gian hàng hoặc người bán" required>
                                <button type="submit" class="search-btn">Tìm kiếm</button>
                            </div>

                        </div>
                    </div>
                </form>

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
                    <a href="{{ route('category.products', ['slug' => $category->slug]) }}" class="category-card">
                        <div class="category-icon {{ $iconClasses[$index % count($iconClasses)] }}">
                            <img src="{{ asset('storage/' . $category->icon) }}" alt="{{ $category->name }}"
                                style="width: 50px; height: 50px;">
                        </div>
                        <h3>{{ $category->name }}</h3>
                        <p>{!! $category->description !!}</p>
                    </a>
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
                    <a href="{{ route('category.products', ['slug' => $category->slug]) }}" class="service-card">
                        <div class="service-icon">
                            <img src="{{ asset('storage/' . $category->icon) }}" alt="{{ $category->name }}"
                                style="width: 50px; height: 50px;">
                        </div>
                        <h3>{{ $category->name }}</h3>
                        <p>{!! $category->description !!}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>


    @if (Auth::guard('customer')->check())
        <!-- Recommended Products -->
        <section class="recommended-products">
            <div class="container">
                <h2 class="section-heading">Gian hàng nổi bật</h2>
                <div class="product-carousel">
                    <div class="carousel-nav prev"><i class="fas fa-chevron-left"></i></div>
                    <div class="product-slides">
                        @foreach ($hotProducts as $product)
                                    <div class="product-card">
                                        <div class="product-badge">
                                            <span class="service-badge">{{ $product->category->type ?? 'Sản phẩm' }}</span>
                                        </div>
                                        <div class="product-img">
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                        </div>
                                        <div class="product-info">
                                            <h3 class="product-title">
                                                {{ Str::limit($product->name, 20, '...') }}
                                            </h3>


                                            @php
                                                $minPrice = $product->productVariants->min('price') ?? 0;
                                                $maxPrice = $product->productVariants->max('price') ?? 0;
                                            @endphp

                                            @if ($minPrice > 0 && $maxPrice > 0)
                                                <div class="product-price">
                                                    {{ number_format($minPrice, 0, ',', '.') }}đ -
                                                    {{ number_format($maxPrice, 0, ',', '.') }}đ
                                                </div>
                                            @else
                                                <div class="product-price">Chưa có giá</div>
                                            @endif

                                            <div class="rating">
                                                <span class="stars">
                                                    @for ($i = 0; $i < 5; $i++)
                                                        @if ($i < ($product->rating ?? 5))
                                                            ★
                                                        @else
                                                            ☆
                                                        @endif
                                                    @endfor
                                                </span>
                                                <span class="reviews">
                                                    {{ $product->reviews()->count() }} Reviews |
                                                    Đơn hoàn thành: {{ $product->completedOrders()->count() }} |
                                                    Khiếu nại: {{ $product->complaintRate() }}%
                                                </span>

                                            </div>

                                            <div class="seller">
                                                Người bán: <a
                                                    href="{{ route('profile.name.site', $product->customer->name ?? '') }}">{{ $product->customer->name ?? 'Unknown' }}</a>
                                            </div>
                                            <div class="product-category">
                                                Sản phẩm: <a href="#">{{ $product->subcategory->name ?? $product->category->name }}</a>
                                            </div>
                                            <div class="action-buttons">
                                                <a href="{{ route('product.detail', $product->slug) }}" class="buy-now">Xem chi
                                                    tiết</a>
                                            </div>
                                        </div>
                                    </div>
                        @endforeach
                    </div>
                    <div class="carousel-nav next"><i class="fas fa-chevron-right"></i></div>
                </div>
            </div>
        </section>
    @endif
    <!-- Thêm CSS -->
@endsection
