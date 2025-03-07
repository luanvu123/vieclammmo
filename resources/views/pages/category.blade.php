@extends('layout')
@section('content')

    <div class="alert-banner">
        <p>Lưu ý đầu, có nghĩa là hàng đó đang có pass hệ thống check trùng của sàn, hãy nhanh chóng khiếu nại đơn hàng và
            báo cho bên mình nhé, vì sản phẩm bạn mua có thể đã từng bán cho người khác trên sàn.</p>
    </div>

    <div class="container category-page">
        <div class="sidebar">
            <div class="filter-section">
                <h3>Bộ lọc</h3>
                <form action="{{ route('category.products', $category->slug) }}" method="GET" id="filter-form">
                    <div class="filter-group">
                        <h4>Chọn 1 hoặc nhiều danh mục con <i class="fas fa-chevron-down"></i></h4>
                        <div class="filter-options">
                            @foreach ($subcategories as $subcategory)
                                <label>
                                    <input type="checkbox" name="subcategories[]" value="{{ $subcategory->id }}"
                                        {{ in_array($subcategory->id, $selectedSubcategories) ? 'checked' : '' }}>
                                    {{ $subcategory->name }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <button type="submit" class="search-btn">Tìm kiếm</button>
                    <a href="{{ route('category.products', $category->slug) }}" class="reset-btn">Đặt lại</a>
                </form>
            </div>
        </div>

        <div class="main-category-content">
            <div class="category-header">
                <h2>{{ $category->name }} <span class="store-count">Tổng {{ $totalProducts }} sản phẩm</span></h2>
            </div>

            <div class="product-grid" id="product-container">
                @if ($products->count() > 0)
                    @foreach ($products as $product)
                        <div class="product-card">
                            <div class="product-badge">
                                <span class="service-badge">{{ $product->category->type ?? 'Sản phẩm' }}</span>
                            </div>
                            <div class="product-img">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                            </div>
                            <div class="product-info">
                                <div class="service-title">{{ $product->name }}</div>
                                @if ($product->productVariants->count() > 0)
                                    {{ number_format($product->productVariants->min('price'), 0, ',', '.') }}đ -
                                    {{ number_format($product->productVariants->max('price'), 0, ',', '.') }}đ
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
                                <div class="seller">Người bán: <a
                                        href="{{ route('profile.name.site', $product->customer->name ?? '') }}">{{ $product->customer->name ?? 'Unknown' }}</a></div>
                                <div class="product-category">Sản phẩm: <a
                                        href="#">{{ $product->subcategory->name ?? $product->category->name }}</a>
                                </div>
                                <div class="product-features">
                                    <p>{{ $product->short_description }}</p>
                                </div>
                                <div class="action-button">
                                    <a href="{{ route('product.detail', $product->slug) }}" class="buy-now">Xem chi
                                        tiết</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="no-products">
                        <p>Không tìm thấy sản phẩm nào phù hợp với bộ lọc.</p>
                    </div>
                @endif
            </div>

            <!-- Pagination -->
            <div class="pagination" id="pagination-container">
                {{ $products->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Xử lý khi form được submit
            $('#filter-form').on('submit', function(e) {
                e.preventDefault();

                var form = $(this);
                var url = form.attr('action');
                var formData = form.serialize();

                // Hiển thị loading
                $('#product-container').html('<div class="loading">Đang tải...</div>');

                // Gửi AJAX request
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: formData,
                    success: function(response) {
                        // Cập nhật chỉ phần sản phẩm và phân trang từ response
                        var newContent = $(response).find('#product-container').html();
                        var newPagination = $(response).find('#pagination-container').html();
                        var totalProducts = $(response).find('.store-count').html();

                        $('#product-container').html(newContent);
                        $('#pagination-container').html(newPagination);
                        $('.store-count').html(totalProducts);

                        // Cập nhật URL trình duyệt mà không cần tải lại trang
                        window.history.pushState({}, '', url + '?' + formData);
                    },
                    error: function() {
                        $('#product-container').html(
                            '<div class="error">Đã xảy ra lỗi. Vui lòng thử lại.</div>');
                    }
                });
            });

            // Xử lý phân trang AJAX
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();

                var url = $(this).attr('href');

                // Hiển thị loading
                $('#product-container').html('<div class="loading">Đang tải...</div>');

                // Gửi AJAX request
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        var newContent = $(response).find('#product-container').html();
                        var newPagination = $(response).find('#pagination-container').html();

                        $('#product-container').html(newContent);
                        $('#pagination-container').html(newPagination);

                        // Cuộn lên đầu danh sách sản phẩm
                        $('html, body').animate({
                            scrollTop: $('.product-grid').offset().top - 20
                        }, 500);

                        // Cập nhật URL
                        window.history.pushState({}, '', url);
                    },
                    error: function() {
                        $('#product-container').html(
                            '<div class="error">Đã xảy ra lỗi. Vui lòng thử lại.</div>');
                    }
                });
            });
        });
    </script>
@endsection
