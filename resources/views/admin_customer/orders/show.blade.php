@extends('layout')
@section('content')
    <div class="post-container">

        <div class="d-flex justify-content-between mb-4">
            <h1>Chi tiết đơn hàng: {{ $order->order_key }}</h1>
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Quay lại</a>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Thông tin đơn hàng</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Mã đơn hàng:</strong> {{ $order->order_key }}</p>
                        <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                        <p>
                            <strong>Trạng thái:</strong>
                            @if($order->status == 'pending')
                                <span
                                    style="display: inline-block; padding: 3px 8px; background-color: #ffc107; color: #000; border-radius: 4px; font-size: 12px;">Chờ
                                    xử lý</span>
                            @elseif($order->status == 'completed')
                                <span
                                    style="display: inline-block; padding: 3px 8px; background-color: #28a745; color: #fff; border-radius: 4px; font-size: 12px;">Hoàn
                                    thành</span>
                            @elseif($order->status == 'canceled')
                                <span
                                    style="display: inline-block; padding: 3px 8px; background-color: #dc3545; color: #fff; border-radius: 4px; font-size: 12px;">Đã
                                    hủy</span>
                            @endif
                        </p>
                        <p><strong>Sản phẩm:</strong> {{ $order->productVariant->product->name }}</p>
                        <p><strong>Biến thể:</strong> {{ $order->productVariant->name }}</p>
                        <p><strong>Số lượng:</strong> {{ $order->quantity }}</p>
                        <p><strong>Giá đơn vị:</strong> {{ number_format($order->productVariant->price) }} VNĐ</p>

                        @if($order->coupon)
                            <p><strong>Mã giảm giá:</strong> {{ $order->coupon->coupon_key }}</p>
                            <p>
                                <strong>Giảm giá:</strong>
                                @if($order->coupon->type == 'percent')
                                    {{ $order->coupon->percent }}% (tối đa {{ number_format($order->coupon->max_amount) }} VNĐ)
                                @else
                                    {{ number_format($order->coupon->max_amount) }} VNĐ
                                @endif
                            </p>
                        @endif

                        <p><strong>Tổng tiền:</strong> <span class="text-danger fw-bold">{{ number_format($order->total) }}
                                VNĐ</span></p>

                        @if($order->required)
                            <p><strong>Yêu cầu:</strong> {{ $order->required }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Chi tiết tài khoản/dữ liệu</h5>
                        <p class="text-danger">Đánh dấu hoặc tải lên file SP lỗi để báo lỗi. Nếu số lượng lỗi nhiều, xin hãy
                            khiếu nại đơn hàng!</p>
                        <span
                            style="display: inline-block; padding: 3px 8px; background-color: #28a745; color: #fff; border-radius: 4px; font-size: 12px;">Thành
                            công</span>
                    </div>
                    <div style="font-size:15px;">

                        <p class="text-danger">* Đơn hàng sẽ bị xóa sản phẩm sau <b>30 ngày</b>, bạn vui lòng lưu về máy để
                            tránh mất hàng!</p>
                        <p class="text-danger">* Nếu cột sản phẩm không phải là tài khoản đăng nhập, mà là 1 chuỗi ngẫu
                            nhiên, số thứ tự hoặc bất kỳ một chuỗi không liên quan nào, có nghĩa là chủ shop đã cố pass hệ
                            thống check trùng của site
                            . Vui lòng khiếu nại đơn hàng và báo cho hỗ trợ của sàn để được hoàn tiền. </p>
                        <p class="text-success">* Vui lòng yêu cầu shop bảo hành trực tiếp trên sàn bằng tính năng bảo hành
                            để được bảo đảm quyền lợi và không nhận BH qua bất kỳ kênh nào khác, rất có thể bạn sẽ nhận được
                            sản phẩm cũ đã bán cho người khác.</p>

                    </div>
                    <div class="card-body">
                        @if($order->orderDetails->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped" id="user-table">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Tài khoản/Email</th>
                                            <th>Giá trị</th>
                                            <th>Trạng thái</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->orderDetails as $index => $detail)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $detail->account }}</td>
                                                <td>{{ $detail->value }}</td>
                                                <td>
                                                    @if($detail->status == 'success')
                                                        <span class="status-span" data-id="{{ $detail->id }}" data-status="success"
                                                            style="display: inline-block; padding: 3px 8px; background-color: #28a745; color: #fff; border-radius: 4px; font-size: 12px; cursor: pointer;">
                                                            Thành công
                                                        </span>
                                                    @else
                                                        <span class="status-span" data-id="{{ $detail->id }}" data-status="error"
                                                            style="display: inline-block; padding: 3px 8px; background-color: #dc3545; color: #fff; border-radius: 4px; font-size: 12px; cursor: pointer;">
                                                            Lỗi
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                        @elseif($order->productVariant->type === null)
                            <div class="alert alert-info">
                                <p>Đây là đơn hàng yêu cầu dịch vụ. Người bán sẽ liên hệ với bạn để thực hiện.</p>
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <p>Chưa có dữ liệu chi tiết cho đơn hàng này.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.status-span').forEach(function (span) {
                    span.addEventListener('click', function () {
                        const detailId = this.getAttribute('data-id');
                        const currentStatus = this.getAttribute('data-status');

                        const newStatus = currentStatus === 'success' ? 'error' : 'success';
                        const csrfToken = '{{ csrf_token() }}';

                        fetch(`/order-details/update-status/${detailId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({ status: newStatus })
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Cập nhật giao diện
                                    if (newStatus === 'success') {
                                        this.setAttribute('data-status', 'success');
                                        this.style.backgroundColor = '#28a745';
                                        this.textContent = 'Thành công';
                                    } else {
                                        this.setAttribute('data-status', 'error');
                                        this.style.backgroundColor = '#dc3545';
                                        this.textContent = 'Lỗi';
                                    }
                                } else {
                                    alert('Cập nhật thất bại, vui lòng thử lại.');
                                }
                            })
                            .catch(error => {
                                console.error('Lỗi khi cập nhật:', error);
                                alert('Có lỗi xảy ra. Vui lòng thử lại sau.');
                            });
                    });
                });
            });
        </script>

    </div>
@endsection
