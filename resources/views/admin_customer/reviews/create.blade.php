@extends('layout')

@section('content')
    <div class="post-container">
        <h2>Đánh giá sản phẩm: {{ $product->name }}</h2>

        <form action="{{ route('reviews.store') }}" method="POST">
            @csrf
            <input type="hidden" name="order_id" value="{{ $order->id }}">
            <input type="hidden" name="product_id" value="{{ $product->id }}">

            <div class="form-group mt-3">
                <label>Đánh giá (1 - 5 sao):</label>
                <select name="rating" class="form-control">
                    @for($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}">{{ $i }} sao</option>
                    @endfor
                </select>
            </div>

            <div class="form-group mt-3">
                <label>Trạng thái chất lượng:</label>
                <div>
                    <input type="checkbox" name="quality_status[]" value="Giao hàng nhanh"> Giao hàng nhanh
                    <input type="checkbox" name="quality_status[]" value="Đóng gói tốt"> Đóng gói tốt
                    <input type="checkbox" name="quality_status[]" value="Sản phẩm đúng như mô tả"> Sản phẩm đúng như mô tả
                </div>
            </div>

            <div class="form-group mt-3">
                <label>Nội dung đánh giá:</label>
                <textarea name="content" class="form-control" rows="4"></textarea>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Gửi đánh giá</button>
        </form>
    </div>
@endsection
