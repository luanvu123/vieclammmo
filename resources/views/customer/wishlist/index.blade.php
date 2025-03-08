@extends('layout')

@section('content')
 <div class="post-container">
    <div class="main-category-content">
        <div class="category-header">
            <h2>Danh sách yêu thích <span class="store-count">Tổng {{ $wishlistProducts->total() }} sản phẩm</span></h2>
        </div>

        <div class="product-grid" id="product-container">
            @if ($wishlistProducts->count() > 0)
                @foreach ($wishlistProducts as $wishlist)
                    <div class="product-card">
                        <div class="product-badge">
                            <span class="service-badge">{{ $wishlist->product->category->type ?? 'Sản phẩm' }}</span>
                        </div>
                        <div class="product-img">
                            <img src="{{ asset('storage/' . $wishlist->product->image) }}" alt="{{ $wishlist->product->name }}">
                        </div>
                        <div class="product-info">
                            <div class="service-title">{{ $wishlist->product->name }}</div>
                            @if ($wishlist->product->productVariants->count() > 0)
                                {{ number_format($wishlist->product->productVariants->min('price'), 0, ',', '.') }}đ -
                                {{ number_format($wishlist->product->productVariants->max('price'), 0, ',', '.') }}đ
                            @else
                                Chưa có giá
                            @endif
                            <div class="rating">
                                <span class="stars">
                                    @for ($i = 0; $i < 5; $i++)
                                        @if ($i < ($wishlist->product->rating ?? 5))
                                            ★
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                </span>
                                <span class="reviews">
                                    {{ $wishlist->product->reviews_count ?? 0 }} Reviews |
                                    Đơn hoàn thành: {{ $wishlist->product->completed_orders ?? 0 }} |
                                    Khiếu nại: {{ $wishlist->product->complaint_percentage ?? '0.0' }}%
                                </span>
                            </div>
                            <div class="seller">Người bán: <a
                                    href="{{ route('profile.name.site', $wishlist->product->customer->name ?? '') }}">{{ $wishlist->product->customer->name ?? 'Unknown' }}</a></div>
                            <div class="product-category">Sản phẩm: <a
                                    href="#">{{ $wishlist->product->subcategory->name ?? $wishlist->product->category->name }}</a>
                            </div>
                            <div class="product-features">
                                <p>{{ $wishlist->product->short_description }}</p>
                            </div>
                            <div class="action-buttons">
                                <a href="{{ route('product.detail', $wishlist->product->slug) }}" class="buy-now"><i class="fa-solid fa-eye"></i> Xem chi tiết</a>
                                <form action="{{ route('wishlist.destroy', $wishlist->product->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                     <button type="submit" class="favorite-button"><i class="fas fa-heart-broken"></i> Xóa Yêu thích</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="no-products">
                    <p>Không có sản phẩm yêu thích nào.</p>
                </div>
            @endif
        </div>

        <div class="pagination" id="pagination-container">
            {{ $wishlistProducts->appends(request()->query())->links() }}
        </div>
    </div>
 </div>
@endsection
