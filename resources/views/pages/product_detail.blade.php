@extends('layout')
@section('content')
    <style>
        .detail-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        /* Header and Banner */
        .tag-label {
            background-color: #28a745;
            color: white;
            padding: 2px 8px;
            font-size: 12px;
            display: inline-block;
            margin-bottom: 5px;
        }

        .product-banner {
            display: flex;
            flex-wrap: wrap;
            margin-top: 20px;
            gap: 20px;
        }

        .product-image {
            flex: 0 0 300px;
            background: linear-gradient(45deg, #ffc107, #fd7e14);
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .telegram-logo {
            width: 180px;
            height: 180px;
        }

        .product-info {
            flex: 1;
            min-width: 300px;
        }

        .product-title {
            color: #28a745;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .rating {
            color: #ffc107;
            margin-bottom: 15px;
        }

        .description {
            margin-bottom: 15px;
            font-size: 14px;
        }

        .seller-info {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            font-size: 14px;
            flex-direction: row;
        }

        .seller-info a {
            color: #007bff;
            text-decoration: none;
            margin-right: 15px;
        }

        .status {
            color: #28a745;
            font-weight: bold;
        }

        .product-category {
            margin-bottom: 15px;
            font-size: 14px;
        }

        .category-link {
            color: #007bff;
            text-decoration: none;
        }

        .product-code {
            margin-bottom: 15px;
            font-size: 14px;
        }

        .price {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .product-data {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .product-action {
            margin-bottom: 15px;
        }

        .action-button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 3px;
            cursor: pointer;
            font-size: 14px;
        }

        .session-info {
            margin-bottom: 20px;
            font-size: 14px;
        }

        .delivery-info {
            font-size: 14px;
            margin-bottom: 20px;
        }

        .buy-button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            cursor: pointer;
            font-weight: bold;
        }

        /* Tabs */
        .tabs {
            display: flex;
            border-bottom: 1px solid #dee2e6;
            margin: 30px 0 20px;
        }

        .tab {
            padding: 10px 20px;
            cursor: pointer;
            border: none;
            background: none;
            font-size: 16px;
        }

        .tab.active {
            border-bottom: 2px solid #28a745;
            color: #28a745;
            font-weight: bold;
        }

        /* API Section */
        .api-section {
            margin-bottom: 30px;
        }

        .api-info {
            margin-bottom: 15px;
            font-size: 14px;
        }

        /* Related Products */
        .related-title {
            margin: 30px 0 20px;
            font-size: 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navigation {
            display: flex;
            gap: 5px;
        }

        .nav-button {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .related-products {
            display: flex;
            gap: 20px;
            overflow-x: auto;
            padding-bottom: 15px;
        }

        .related-product {
            flex: 0 0 200px;
            background-color: white;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .related-image {
            height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
        }

        .related-image img {
            max-width: 100%;
            max-height: 100%;
        }

        .related-info {
            padding: 10px;
        }

        .related-title-text {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .related-rating {
            color: #ffc107;
            font-size: 12px;
            margin-bottom: 5px;
        }

        .related-seller {
            font-size: 12px;
            margin-bottom: 5px;
        }

        .related-price {
            font-weight: bold;
            margin-top: 10px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .product-banner {
                flex-direction: column;
            }

            .product-image {
                width: 100%;
                max-width: 100%;
            }

            .related-products {
                overflow-x: scroll;
            }
        }

        .radio-option {
            display: inline-block;
            /* Thay vì block để thu nhỏ theo nội dung */
            padding: 10px 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            margin: 5px;
            cursor: pointer;
            font-weight: bold;
            white-space: nowrap;
            /* Giữ nội dung trên một dòng */
        }

        .radio-option input {
            margin-right: 8px;
            transform: scale(1.2);
        }

        .radio-option:hover {
            background-color: #f5f5f5;
        }

        /* Khi chọn radio button */
        .radio-option input:checked+label {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .buy-button {
            background-color: #ff5722;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .favorite-button {
            background-color: #e91e63;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .buy-button:hover {
            background-color: #e64a19;
        }

        .favorite-button:hover {
            background-color: #c2185b;
        }

        .tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .tab {
            padding: 10px 15px;
            border: none;
            background-color: #f1f1f1;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
        }

        .tab.active {
            background-color: #ff5722;
            color: white;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        /* CSS cho đánh giá khách hàng */
        .review {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }

        .review .customer-name {
            font-weight: bold;
        }

        .review .rating {
            color: #ff9800;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-overlay {
            position: absolute;
            width: 100%;
            height: 100%;
        }

        .modal-content {
            position: absolute;
            background: white;
            padding: 20px;
            width: 300px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 10px;
        }
.related-products {
    display: flex;
    overflow: hidden;
}
.related-product {
    width: 100%;
    text-align: center;
    padding: 10px;
}
.related-image img {
    width: 100%;
    height: auto;
    border-radius: 5px;
}

        #description-site {
            max-height: 300px;
            /* Giới hạn chiều cao */
            overflow-y: auto;
            /* Thêm thanh cuộn nếu nội dung dài */
            padding-right: 10px;
            /* Giúp tránh che khuất nội dung */
        }
    </style>

    <div class="detail-container">
        <!-- Product Banner -->
        <div class="product-banner">
            <div class="product-image">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
            </div>

            <div class="product-info">
                <span class="tag-label">Sản phẩm</span>
                <h1 class="product-title">{{ $product->name }}</h1>

                <div class="rating">
                    ★★★★★ <span style="color: #666; font-size: 14px;">(4.8/5)</span>
                </div>

                <div class="description">
                    {{ $product->short_description }}
                </div>

                <div class="seller-info">
                    <span>Người bán: </span>
                    <a href="javascript:void(0);" onclick="showSellerInfo('{{ $product->customer->id }}')">
                        {{ $product->customer->name }}
                    </a>
                    <span>|</span>

                    <span>Online:</span>
                    <span class="status">
                        {{ \Carbon\Carbon::parse($product->customer->last_active_at)->diffForHumans() }}
                    </span>
                </div>





                <div class="product-category">
                    <span>Danh mục: </span>
                    <a href="#" class="category-link">{{ $product->category->name }}</a>
                </div>

                <div class="product-stock">
                    <span>Kho: <span id="stock-quantity">
                            {{ $product->productVariants->first()->stocks->sum('quantity_success') ?? 0 }}
                        </span></span>
                </div>

                <div class="price">
                    <span id="product-price">
                        {{ number_format($product->productVariants->first()->price ?? 0, 0, ',', '.') }} VNĐ
                    </span>
                </div>

                <!-- Hiển thị danh sách biến thể -->
                @if ($product->productVariants->count() > 0)
                    <div class="product-action">
                        @foreach ($product->productVariants as $variant)
                            <label class="radio-option">
                                <input type="radio" name="product_variant" value="{{ $variant->id }}"
                                    data-price="{{ $variant->price }}"
                                    data-stock="{{ $variant->stocks->sum('quantity_success') }}"
                                    {{ $loop->first ? 'checked' : '' }}>
                                {{ $variant->name }} - {{ number_format($variant->price, 0, ',', '.') }} VNĐ
                                @if ($variant->stocks->sum('quantity_success') > 0)
                                    (Còn hàng: {{ $variant->stocks->sum('quantity_success') }})
                                @else
                                    (Hết hàng)
                                @endif
                            </label>
                        @endforeach
                    </div>
                @endif


                @if (Auth::guard('customer')->check())
                    <div class="action-buttons">
                        <button class="buy-button">Mua hàng</button>
                        <button class="favorite-button">Thêm yêu thích ❤️</button>
                    </div>
                @else
                    <div class="delivery-info">
                        Vui lòng đăng nhập để mua hàng từ shop.
                    </div>
                    <a href="{{ route('login') }}" class="buy-button">Đăng nhập</a>
                @endif
            </div>
        </div>

        <!-- Tabs -->
        <div class="tabs">
            <button class="tab active" data-tab="description-site">Mô tả</button>
            <button class="tab" data-tab="reviews">Reviews</button>
            <button class="tab" data-tab="api">API</button>
        </div>

        <!-- Nội dung Tabs -->
        <div class="tab-content active" id="description-site">
            <h3>Thông tin sản phẩm</h3>
            <p>{!! $product->description !!}</p>
        </div>

        <div class="tab-content" id="reviews">
            <h3>Đánh giá từ khách hàng</h3>
        </div>

        <div class="tab-content" id="api">
            <h3>Mua hàng bằng API:</h3>
            <div class="api-info">Vui lòng đăng nhập để mua bằng API.</div>
            <button class="action-button">Đăng nhập</button>
        </div>
       <div class="related-title">
    <h3>Sản phẩm tương tự</h3>
</div>

<div class="related-products slider">
    @foreach ($relatedProducts as $product)
    <div class="product-card">
        <div class="product-badge">
            <span class="service-badge">{{ $product->category->type ?? 'Sản phẩm' }}</span>
        </div>
        <div class="product-img">
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
        </div>
        <div class="product-info">
            <div class="service-title">{{ $product->name }}</div>

            @php
                $minPrice = $product->productVariants->min('price') ?? 0;
                $maxPrice = $product->productVariants->max('price') ?? 0;
            @endphp

            @if ($minPrice > 0 && $maxPrice > 0)
                {{ number_format($minPrice, 0, ',', '.') }}đ - {{ number_format($maxPrice, 0, ',', '.') }}đ
            @else
                Chưa có giá
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
                    {{ $product->reviews_count ?? 0 }} Reviews |
                    Đơn hoàn thành: {{ $product->completed_orders ?? 0 }} |
                    Khiếu nại: {{ $product->complaint_percentage ?? '0.0' }}%
                </span>
            </div>

            <div class="seller">Người bán: <a href="#">{{ $product->customer->name ?? 'Unknown' }}</a></div>
            <div class="product-category">Sản phẩm: <a href="#">{{ $product->subcategory->name ?? $product->category->name }}</a></div>
            <div class="product-features">
                <p>{{ $product->short_description }}</p>
            </div>
            <div class="action-button">
                <a href="{{ route('product.detail', $product->slug) }}" class="buy-now">Xem chi tiết</a>
            </div>
        </div>
    </div>
@endforeach

</div>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const tabs = document.querySelectorAll(".tab");
            const contents = document.querySelectorAll(".tab-content");

            tabs.forEach((tab) => {
                tab.addEventListener("click", function() {
                    // Xóa class active khỏi tất cả tabs và nội dung
                    tabs.forEach(t => t.classList.remove("active"));
                    contents.forEach(c => c.classList.remove("active"));

                    // Thêm class active vào tab được click và hiển thị nội dung tương ứng
                    this.classList.add("active");
                    document.getElementById(this.getAttribute("data-tab")).classList.add("active");
                });
            });

            // Dữ liệu giả định đánh giá từ khách hàng (có thể thay bằng dữ liệu thật từ API)
            const customerReviews = [{
                    name: "Nguyễn Văn A",
                    rating: 5,
                    comment: "Sản phẩm rất tốt!"
                },
                {
                    name: "Trần Thị B",
                    rating: 4,
                    comment: "Chất lượng khá ổn."
                }
            ];

            const reviewsContainer = document.getElementById("reviews-container");

            if (customerReviews.length > 0) {
                customerReviews.forEach(review => {
                    const reviewElement = document.createElement("div");
                    reviewElement.classList.add("review");
                    reviewElement.innerHTML = `
                <div class="customer-name">${review.name}</div>
                <div class="rating">⭐ ${"⭐".repeat(review.rating)}</div>
                <p>${review.comment}</p>
            `;
                    reviewsContainer.appendChild(reviewElement);
                });
            } else {
                reviewsContainer.innerHTML = "<p>Không có đánh giá nào.</p>";
            }
        });
    </script>
    <script>
        document.querySelectorAll("input[name='product_variant']").forEach(input => {
            input.addEventListener("change", function() {
                document.getElementById("product-price").innerText =
                    new Intl.NumberFormat('vi-VN').format(this.dataset.price) + " VNĐ";

                document.getElementById("stock-quantity").innerText = this.dataset.stock;
            });
        });
    </script>


@endsection
