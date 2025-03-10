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
                    <thead>
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
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
                              <td>
                                    @if($order->status == 'pending')
                                        <span style="display: inline-block; padding: 3px 8px; background-color: #ffc107; color: #000; border-radius: 4px; font-size: 12px;">Chờ xử lý</span>
                                    @elseif($order->status == 'completed')
                                        <span style="display: inline-block; padding: 3px 8px; background-color: #28a745; color: #fff; border-radius: 4px; font-size: 12px;">Hoàn thành</span>
                                    @elseif($order->status == 'canceled')
                                        <span style="display: inline-block; padding: 3px 8px; background-color: #dc3545; color: #fff; border-radius: 4px; font-size: 12px;">Đã hủy</span>
                                    @endif
                                </td>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                 <td>{{ $order->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Bạn chưa có đơn hàng nào</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>


        </div>
    </div>

    </div>
@endsection
