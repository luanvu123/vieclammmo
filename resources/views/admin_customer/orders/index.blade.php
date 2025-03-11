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
                                <th scope="col">#</th>
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
                            @forelse($orders as $key => $order)
                                                    <tr>
                                                        <th scope="row">{{$key}}</th>
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
                                                       <!-- Cột đánh giá -->
<td class="text-center">
    @php
        $hasReview = App\Models\Review::where('customer_id', Auth::guard('customer')->id())
            ->where('order_id', $order->id)
            ->where('product_id', $order->productVariant->product->id)
            ->exists();
    @endphp

    @if($order->status == 'completed')
        @if(!$hasReview)
            <a href="javascript:void(0);" class="open-review-modal" data-order-id="{{ $order->id }}" data-product-id="{{ $order->productVariant->product->id }}" data-product-name="{{ $order->productVariant->product->name }}">
                <i class="fas fa-star text-warning"></i>
            </a>
        @else
            <i class="fas fa-star text-secondary" data-bs-toggle="tooltip" title="Đã đánh giá"></i>
        @endif
    @else
        <i class="fas fa-star text-muted" data-bs-toggle="tooltip" title="Chưa thể đánh giá"></i>
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
<!-- Modal Đánh giá -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="reviewForm" method="POST" action="{{ route('reviews.store') }}">
                @csrf
                <input type="hidden" name="order_id" id="order_id">
                <input type="hidden" name="product_id" id="product_id">

                <div class="modal-header">
                    <h5 class="modal-title" id="reviewModalLabel">Đánh giá sản phẩm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Sản phẩm:</label>
                        <input type="text" id="product_name" class="form-control" readonly>
                    </div>

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
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const reviewModal = new bootstrap.Modal(document.getElementById('reviewModal'));

        document.querySelectorAll('.open-review-modal').forEach(item => {
            item.addEventListener('click', function () {
                const orderId = this.getAttribute('data-order-id');
                const productId = this.getAttribute('data-product-id');
                const productName = this.getAttribute('data-product-name');

                document.getElementById('order_id').value = orderId;
                document.getElementById('product_id').value = productId;
                document.getElementById('product_name').value = productName;

                reviewModal.show();
            });
        });
    });
</script>

    </div>
@endsection
