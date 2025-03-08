@extends('layout')
@section('content')
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

                    <a
                        href="{{ route('profile.name.site', $product->customer->name ?? '') }}">{{ $product->customer->name ?? 'Unknown' }}</a>
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

                <!-- Nhập số lượng -->
                <div class="quantity-box">
                    <label for="quantity">Số lượng:</label>
                    <input type="number" id="quantity" min="1" value="1">

                </div>

                <!-- Hiển thị tổng tiền -->
                <div class="total-price">
                    Tổng tiền: <span
                        id="total-price">{{ number_format($product->productVariants->first()->price ?? 0, 0, ',', '.') }}
                        VNĐ</span>
                </div>

                @if (Auth::guard('customer')->check())
                    <div class="action-buttons">
                        <button class="buy-button" id="buy-now">Mua hàng</button>
                       <form action="{{ route('wishlist.store') }}" method="POST">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->id }}">
    <button type="submit" class="favorite-button"><i class="fa fa-heart"></i> Yêu thích</button>
</form>

                    </div>
                @else
                    <div class="delivery-info">
                        Vui lòng đăng nhập để mua hàng từ shop.
                    </div>
                    <a href="{{ route('login.customer') }}" class="buy-button">Đăng nhập</a>
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
                        <div class="service-title"> {{ Str::limit($product->name, 20, '...') }}</div>

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

                        <div class="seller">
                            Người bán: <a
                                href="{{ route('profile.site', $product->customer->name ?? '') }}">{{ $product->customer->name ?? 'Unknown' }}</a>
                        </div>
                        <div class="product-category">Sản phẩm: <a
                                href="#">{{ $product->subcategory->name ?? $product->category->name }}</a></div>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let quantityInput = document.getElementById('quantity');
            let productPrice = document.getElementById('product-price');
            let totalPriceElement = document.getElementById('total-price');
            let buyButton = document.getElementById('buy-now');

            // Cập nhật tổng tiền khi chọn biến thể hoặc thay đổi số lượng
            function updateTotalPrice() {
                let selectedVariant = document.querySelector('input[name="product_variant"]:checked');
                let quantity = parseInt(quantityInput.value) || 1;
                let price = selectedVariant ? parseInt(selectedVariant.dataset.price) : 0;
                let total = price * quantity;
                totalPriceElement.innerText = total.toLocaleString('vi-VN') + " VNĐ";
            }

            // Lắng nghe sự kiện thay đổi số lượng
            quantityInput.addEventListener('input', updateTotalPrice);

            // Lắng nghe sự kiện chọn biến thể
            document.querySelectorAll('input[name="product_variant"]').forEach(input => {
                input.addEventListener('change', function() {
                    productPrice.innerText = parseInt(this.dataset.price).toLocaleString('vi-VN') +
                        " VNĐ";
                    updateTotalPrice();
                });
            });

            // Xử lý khi nhấn nút "Mua hàng"
            document.getElementById('buy-now').addEventListener('click', function() {
                let selectedVariant = document.querySelector('input[name="product_variant"]:checked');
                let quantity = document.getElementById('quantity').value;

                if (!selectedVariant) {
                    alert('Vui lòng chọn biến thể sản phẩm!');
                    return;
                }

                fetch("{{ route('order.store') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        },
                        body: JSON.stringify({
                            product_variant_id: selectedVariant.value,
                            quantity: quantity,
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert("Đơn hàng đã được tạo thành công!");
                        } else {
                            alert(data.error || "Có lỗi xảy ra!");
                        }
                    });
            });

        });
    </script>


@endsection
