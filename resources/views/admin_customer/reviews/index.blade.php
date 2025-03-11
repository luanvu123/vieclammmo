@extends('layout')
@section('content')
    <div class="post-container">
        <h1 class="mb-4">Danh sách đánh giá của bạn</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($reviews->isEmpty())
            <p>Bạn chưa đánh giá sản phẩm nào.</p>
        @else
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="user-table">
                            <thead>
                                <tr>
                                    <th>Mã đơn hàng</th>
                                    <th>Sản phẩm</th>
                                    <th>Đánh giá</th>
                                    <th>Nội dung</th>
                                    <th>Trạng thái chất lượng</th>
                                    <th>Ngày đánh giá</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reviews as $review)
                                    <tr>
                                        <td>{{ $review->order->order_key ?? 'N/A' }}</td>
                                        <td>{{ $review->product->name ?? 'N/A' }}</td>
                                        <td>{{ $review->rating }} / 5</td>
                                        <td>{{ $review->content ?? 'Không có nội dung' }}</td>
                                        <td>{{ $review->quality_status }}</td>
                                        <td>{{ $review->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('reviews.edit', $review->id) }}" class="btn btn-primary btn-sm">Sửa</a>
                                            <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa đánh giá này không?')">Xóa</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
