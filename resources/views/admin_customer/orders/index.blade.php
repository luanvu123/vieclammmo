@extends('layout')
@section('content')
    <div class="post-container">
<style>
    /* Kiểu dáng của Modal */
    .custom-modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
    animation: fadeIn 0.3s ease;
}

.custom-modal-content {
    background-color: #ffffff;
    margin: 10% auto;
    padding: 0;
    border-radius: 8px;
    width: 90%;
    max-width: 600px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    position: relative;
    animation: slideDown 0.3s ease;
}

.custom-modal-header {
    background-color: #f8f9fa;
    padding: 15px 20px;
    border-bottom: 1px solid #e9ecef;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.custom-modal-header h5 {
    margin: 0;
    font-size: 18px;
    color: #333;
}

.custom-modal-body {
    padding: 20px;
}

.close {
    color: #aaa;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
    transition: color 0.2s ease;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
}

/* Animation Keyframes */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .custom-modal-content {
        margin: 20% auto;
        width: 95%;
    }
}

</style>
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
                                <th>Người bán</th>
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
                                                        <td>{{ $order->productVariant->product->customer->name }}</td>
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
            <!-- Biểu tượng ngôi sao, bấm vào để hiện Modal -->
            <i class="fas fa-star text-warning" onclick="openModal('reviewModal{{ $order->id }}')" style="cursor: pointer;"></i>

            <!-- Modal -->
            <div id="reviewModal{{ $order->id }}" class="custom-modal">
                <div class="custom-modal-content">
                    <div class="custom-modal-header">
                        <h5>Đánh giá sản phẩm: {{ $order->productVariant->product->name }}</h5>
                        <span class="close" onclick="closeModal('reviewModal{{ $order->id }}')">&times;</span>
                    </div>
                    <div class="custom-modal-body">
                        <form action="{{ route('reviews.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                            <input type="hidden" name="product_id" value="{{ $order->productVariant->product->id }}">

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
                                    <input type="checkbox" name="quality_status[]" value="Giao hàng nhanh"> Giao hàng nhanh<br>
                                    <input type="checkbox" name="quality_status[]" value="Đóng gói tốt"> Đóng gói tốt<br>
                                    <input type="checkbox" name="quality_status[]" value="Sản phẩm đúng như mô tả"> Sản phẩm đúng như mô tả
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <label>Nội dung đánh giá:</label>
                                <textarea name="content" class="form-control" rows="4"></textarea>
                            </div>

                            <div class="mt-3 text-end">
                                <button type="button" class="btn btn-secondary" onclick="closeModal('reviewModal{{ $order->id }}')">Đóng</button>
                                <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <i class="fas fa-star text-secondary" title="Đã đánh giá"></i>
        @endif
    @else
        <i class="fas fa-star text-muted" title="Chưa thể đánh giá"></i>
    @endif
</td>


                                                        <td class="text-center">

                                                                 <a href="{{ route('messages.create', ['customerId' => $order->productVariant->product->customer_id]) }}"> <i class="fas fa-comments text-primary"></i></a>
                                                        </td>
                                                        <td class="text-center">
    @if($order->status == 'completed' || $order->status == 'pending')
        <!-- Icon Khiếu nại -->
        <i class="fas fa-exclamation-circle text-danger" onclick="openModal('complaintModal{{ $order->id }}')" style="cursor: pointer;"></i>

        <!-- Modal Khiếu nại -->
        <div id="complaintModal{{ $order->id }}" class="custom-modal">
            <div class="custom-modal-content">
                <div class="custom-modal-header">
                    <h5>Gửi Khiếu Nại</h5>
                    <span class="close" onclick="closeModal('complaintModal{{ $order->id }}')">&times;</span>
                </div>
                <div class="custom-modal-body">
                    <form action="{{ route('complaints.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $order->id }}">

                        <div class="form-group mt-3">
                            <label>Nội dung khiếu nại:</label>
                            <textarea name="content" class="form-control" rows="4"></textarea>
                        </div>

                        <div class="mt-3 text-end">
                            <button type="button" onclick="closeModal('complaintModal{{ $order->id }}')" class="btn btn-secondary">Đóng</button>
                            <button type="submit" class="btn btn-primary">Gửi khiếu nại</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @else
        <i class="fas fa-exclamation-circle text-muted" title="Không thể khiếu nại"></i>
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
<script>
 function openModal(modalId) {
    document.getElementById(modalId).style.display = 'block';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

// Đóng modal khi click ngoài vùng modal
window.onclick = function(event) {
    if (event.target.classList.contains('custom-modal')) {
        event.target.style.display = 'none';
    }
}

</script>
    </div>
@endsection
