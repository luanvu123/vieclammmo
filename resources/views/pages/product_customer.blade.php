@extends('layout')
@section('content')
<div class="container product-customer-page">
    <div class="header">
        <h2>Tất cả sản phẩm của người bán: {{ $customer->name }}</h2>
    </div>

    @if ($products->count() > 0)
        <div class="product-grid">
            @foreach ($products as $product)
                <div class="product-card">
                    <div class="product-badge">
                        <span class="service-badge">{{ $product->category->type ?? 'Sản phẩm' }}</span>
                    </div>
                    <div class="product-img">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    </div>
                    <div class="product-info">
                        <div class="service-title">{{ Str::limit($product->name, 20, '...') }}</div>

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

                        <div class="action-buttons">
                            <a href="{{ route('product.detail', $product->slug) }}" class="buy-now">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="pagination">{{ $products->links() }}</div>
    @else
        <p>Người bán này chưa có sản phẩm nào.</p>
    @endif
</div>
@endsection
