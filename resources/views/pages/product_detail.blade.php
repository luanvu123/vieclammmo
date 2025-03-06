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
    </style>

    <div class="detail-container">
        <!-- Product Banner -->
        <div class="product-banner">
            <div class="product-image">
                <svg class="telegram-logo" viewBox="0 0 240 240" fill="white">
                    <path d="M120,5 L8,115 L112,140 L80,235 L192,125 L88,100z" />
                </svg>
            </div>

            <div class="product-info">
                <span class="tag-label">Sản phẩm</span>
                <h1 class="product-title">Telegram 1DATA/SESSION ngăm trải, spam khỏe</h1>

                <div class="rating">
                    ★★★★★ <span style="color: #666; font-size: 14px;">(4.8/5)</span>
                </div>

                <div class="description">
                    MÓ TẢ GIAN HÀNG TRƯỚC KHI MUA, SI GỞ SẼ KHÔNG BẢO HÀNH VỚI KHÁCH HÀNG LÀM SAI NHÉ
                </div>

                <div class="seller-info">
                    <span>Người bán: </span>
                    <a href="#">lamvinaki</a>
                    <span>|</span>
                    <span>Online:</span>
                    <span class="status">Có sẵn</span>
                </div>

                <div class="product-category">
                    <span>Danh mục: </span>
                    <a href="#" class="category-link">Tài khoản Telegram</a>
                </div>

                <div class="product-code">
                    <span>Kho: 64</span>
                </div>
                <div class="price">35.000 VNĐ</div>
                <div class="product-action">
                    <label class="radio-option">
                        <input type="radio" name="tddata_option" value="30" checked> TDDATA 30 ngày hoặc 5 lần gửi về
                        tất cả các thiết bị
                    </label>
                    <label class="radio-option">
                        <input type="radio" name="tddata_option" value="10"> TDDATA 10 ngày hoặc 3 lần gửi về tất cả
                        các thiết bị
                    </label>
                    <label class="radio-option">
                        <input type="radio" name="tddata_option" value="50"> TDDATA 50 ngày
                    </label>
                </div>




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

        <!-- Tab Content Sections -->
        <div class="tab-content active" id="description-site">
            <h3>Thông tin sản phẩm</h3>
            <p>Chi tiết về sản phẩm...</p>
        </div>

        <div class="tab-content" id="reviews">
            <h3>Đánh giá từ khách hàng</h3>
            <div id="reviews-container">
                <!-- Đánh giá sẽ được hiển thị tại đây -->
            </div>
        </div>

        <div class="tab-content" id="api">
            <h3>Mua hàng bằng API:</h3>
            <div class="api-info">Vui lòng đăng nhập để mua bằng API.</div>
            <button class="action-button">Đăng nhập</button>
        </div>


        <!-- Related Products -->
        <div class="related-title">
            <h3>Sản phẩm tương tự</h3>
            <div class="navigation">
                <div class="nav-button">◀</div>
                <div class="nav-button">▶</div>
            </div>
        </div>

        <div class="related-products">
            <!-- TikTok Product -->
            <div class="related-product">
                <div class="related-image">
                    <img src="/api/placeholder/200/150" alt="TikTok"
                        style="background-color: black; width: 100%; height: 100%;" />
                </div>
                <div class="related-info">
                    <div class="related-title-text">Tài khoản QC và mô Ads TikTok cực khỏe đã lên ID</div>
                    <div class="related-rating">★★★★☆ (4.7/5)</div>
                    <div class="related-seller">Sản phẩm: <a href="#" class="category-link">Tài khoản</a></div>
                    <div class="related-seller">Người bán: <a href="#">lamvinaki</a></div>
                    <div class="related-price">12.000 đ - 1.000.000 đ</div>
                </div>
            </div>

            <!-- Facebook Product -->
            <div class="related-product">
                <div class="related-image">
                    <img src="/api/placeholder/200/150" alt="Facebook"
                        style="background-color: #3b5998; width: 100%; height: 100%;" />
                </div>
                <div class="related-info">
                    <div class="related-title-text">FB NET | ID LUCK | PIN | 1 ID 150.000 PT 2019-2024</div>
                    <div class="related-rating">★★★★☆ (4.5/5)</div>
                    <div class="related-seller">Sản phẩm: <a href="#" class="category-link">Tài khoản FB</a></div>
                    <div class="related-seller">Người bán: <a href="#">lamvinaki</a></div>
                    <div class="related-price">170.000 đ - 255.000 đ</div>
                </div>
            </div>

            <!-- Spotify Product -->
            <div class="related-product">
                <div class="related-image">
                    <img src="/api/placeholder/200/150" alt="Spotify"
                        style="background-color: #1ED760; width: 100%; height: 100%;" />
                </div>
                <div class="related-info">
                    <div class="related-title-text">SPOTIFY PREMIUM 6 THÁNG + Ngẫu nhiên đến 1 năm</div>
                    <div class="related-rating">★★★★★ (5/5)</div>
                    <div class="related-seller">Sản phẩm: <a href="#" class="category-link">Tài khoản Spotify</a>
                    </div>
                    <div class="related-seller">Người bán: <a href="#">lamvinaki</a></div>
                    <div class="related-price">100.000 đ - 190.000 đ</div>
                </div>
            </div>

            <!-- Meta/Facebook Product -->
            <div class="related-product">
                <div class="related-image">
                    <img src="/api/placeholder/200/150" alt="Meta"
                        style="background-color: #4267B2; width: 100%; height: 100%;" />
                </div>
                <div class="related-info">
                    <div class="related-title-text">Clone Facebook 2023 Việt Bật BM ẩn MAILFB</div>
                    <div class="related-rating">★★★★☆ (4.6/5)</div>
                    <div class="related-seller">Sản phẩm: <a href="#" class="category-link">Tài khoản FB</a></div>
                    <div class="related-seller">Người bán: <a href="#">lamvinaki</a></div>
                    <div class="related-price">10 đ - 35.000 đ</div>
                </div>
            </div>

            <!-- Fanpage Product -->
            <div class="related-product">
                <div class="related-image">
                    <img src="/api/placeholder/200/150" alt="Fanpage"
                        style="background-color: #4267B2; width: 100%; height: 100%;" />
                </div>
                <div class="related-info">
                    <div class="related-title-text">Page Full CS.98->100k Followers/Người Việt</div>
                    <div class="related-rating">★★★★★ (5/5)</div>
                    <div class="related-seller">Sản phẩm: <a href="#" class="category-link">Tài khoản FB</a></div>
                    <div class="related-seller">Người bán: <a href="#">lamvinaki</a></div>
                    <div class="related-price">700.000 đ - 2.400.000 đ</div>
                </div>
            </div>
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
@endsection
