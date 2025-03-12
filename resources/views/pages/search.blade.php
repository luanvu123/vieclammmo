@extends('layout')
@section('content')
<div class="container search-page">
    <div class="search-header">
        <h2>Kết quả tìm kiếm cho: "{{ $keyword }}"</h2>
    </div>

    @if ($searchType === 'Sản phẩm')
        <div class="product-grid">
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
    {{ $product->reviews()->count() }} Reviews |
    Đơn hoàn thành: {{ $product->completedOrders()->count() }} |
    Khiếu nại: {{ $product->complaintRate() }}%
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
                            <div class="action-buttons">
                                <a href="{{ route('product.detail', $product->slug) }}" class="buy-now">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p>Không tìm thấy sản phẩm nào phù hợp.</p>
            @endif
        </div>
        <div class="pagination">{{ $products->links() }}</div>
    @elseif ($searchType === 'Người bán')
        <div class="seller-grid">
            @if ($customers->count() > 0)
                @foreach ($customers as $customer)
                    <div class="seller-card">
                        <h3>{{ $customer->name }}</h3>
                        <a href="{{ route('profile.name.site', $customer->name) }}" class="btn">Xem hồ sơ</a>
                    </div>
                @endforeach
            @else
                <p>Không tìm thấy người bán nào phù hợp.</p>
            @endif
        </div>
        <div class="pagination">{{ $customers->links() }}</div>
    @endif
</div>
@endsection
