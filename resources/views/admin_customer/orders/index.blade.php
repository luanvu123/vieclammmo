@extends('layout')
@section('content')
    <div class="post-container">

        <h1 class="mb-4">Danh sách đơn hàng của bạn</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="user-table">
                        <thead class="table-primary">
                            <tr>
                                <th>Mã đơn hàng</th>
                                <th>Sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Tổng tiền</th>
                                <th>Coupon</th>
                                <th>Giảm</th>
                                <th>Trạng thái</th>
                                <th>Đánh giá</th>
                                <th>Chat</th>
                                <th>Khiếu nại</th>
                                <th>Ngày đặt</th>
                                <th>Ngày cập nhật</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                                    <tr>
                                                        <td>
                                                            <a href="{{ route('orders.show', $order->order_key) }}">
                                                                {{ $order->order_key }}
                                                            </a>
                                                        </td>
                                                        <td>{{ $order->productVariant->product->name }} - {{ $order->productVariant->name }}</td>
                                                        <td>{{ $order->quantity }}</td>
                                                        <td>{{ number_format($order->total) }} VNĐ</td>
                                                        <td>{{ $order->coupon->coupon_key ?? 'Không có' }}</td>
                                                        <td>{{ number_format($order->discount_amount, 0, ',', '.') }}đ</td>
                                                        <td>
                                                            @if($order->status == 'pending')
                                                                <span class="text-yellow-custom">Chờ xử lý</span>
                                                            @elseif($order->status == 'completed')
                                                                <span class="text-green-custom">Hoàn thành</span>
                                                            @elseif($order->status == 'canceled')
                                                                <span class="text-red-custom">Đã hủy</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @php
                                                                $hasReview = App\Models\Review::where('customer_id', Auth::guard('customer')->id())
                                                                    ->where('order_id', $order->id)
                                                                    ->where('product_id', $order->productVariant->product->id)
                                                                    ->exists();
                                                            @endphp
                                                            @if($order->status == 'completed')
                                                                @if(!$hasReview)
                                                                    <a href="{{ route('reviews.create', ['orderId' => $order->id, 'productId' => $order->productVariant->product->id]) }}"
                                                                        data-bs-toggle="tooltip" title="Tạo đánh giá">
                                                                        <i class="fas fa-star text-warning"></i>
                                                                    </a>
                                                                @else
                                                                    <i class="fas fa-star text-secondary" data-bs-toggle="tooltip" title="Đã đánh giá"></i>
                                                                @endif
                                                            @else
                                                                <i class="fas fa-star text-muted" data-bs-toggle="tooltip"
                                                                    title="Chưa thể đánh giá"></i>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="#" data-bs-toggle="tooltip" title="Chat với shop">
                                                                <i class="fas fa-comments text-primary"></i>
                                                            </a>
                                                        </td>
                                                        <td class="text-center">
                                                            @if($order->status == 'completed' || $order->status == 'pending')
                                                                <a href="#" data-bs-toggle="tooltip" title="Gửi khiếu nại">
                                                                    <i class="fas fa-exclamation-circle text-danger"></i>
                                                                </a>
                                                            @else
                                                                <i class="fas fa-exclamation-circle text-muted" data-bs-toggle="tooltip"
                                                                    title="Không thể khiếu nại"></i>
                                                            @endif
                                                        </td>
                                                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                                        <td>{{ $order->updated_at->format('d/m/Y H:i') }}</td>
                                                    </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="text-center">Bạn chưa có đơn hàng nào</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>


            </div>
        </div>

    </div>
@endsection
