@extends('layouts.customer')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                        <h4 class="page-title">Quản lý Đơn hàng</h4>
                        <div class="">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item active">Danh sách Đơn hàng</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Danh sách Đơn hàng</h4>
                        </div>
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table class="table mb-0" id="datatable_1">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Mã đơn hàng</th>
                                            <th>Người đặt hàng</th>
                                            <th>Ngày đặt</th>
                                            <th>Sản phẩm</th>
                                            <th>Biến thể sản phẩm</th>
                                            <th>Số lượng</th>
                                            <th>Tổng cộng</th>
                                            <th>Chiết khấu (4%)</th>
                                            <th>Coupon</th>
                                            <th>Số tiền đã giảm</th>
                                            <th>Trạng thái</th>
                                            <th class="text-end">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $key => $order)
                                                                            <tr>
                                                                                <th>{{$key}}</th>

                                                                                <td> <a
                                                                                        href="{{ route('order-detail.show', $order->id) }}">{{ $order->order_key }}</a>
                                                                                </td>
                                                                                <td>
                                                                                      <a href="{{ route('messages.create', ['customerId' => $order->productVariant->product->customer_id]) }}">
                                 {{ $order->customer->name}}
                            </a>

                                                                                 </td>
                                                                                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                                                                <td>{{ $order->productVariant->product->name ?? 'Không tìm thấy sản phẩm' }}
                                                                                </td>
                                                                                <td>{{ $order->productVariant->name ?? 'Không tìm thấy biến thể' }}</td>
                                                                                <td>{{ $order->quantity }}</td>
                                                                                <td>{{ number_format($order->total, 0, ',', '.') }}đ</td>
                                                                                <td>
                                                                                    @php
                                                                                        $discount = $order->total * 0.04;
                                                                                    @endphp
                                                                                    {{ number_format($discount, 0, ',', '.') }}đ
                                                                                </td>
                                                                                <td>{{ $order->coupon->coupon_key ?? 'Không có' }}</td>
                                                                                <td>{{ number_format($order->discount_amount, 0, ',', '.') }}đ</td>
                                                                          <td>
    <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'pending' ? 'warning' : 'danger') }}">
        {{ ucfirst($order->status) }}
    </span>
</td>
<td class="text-end">
    @if($order->status == 'pending')
        <div class="col-auto">
            <button class="btn bg-primary text-white" data-bs-toggle="modal" data-bs-target="#editStatusModal{{ $order->id }}">
                <i class="fas fa-edit me-1"></i>
            </button>
        </div>
    @endif
</td>


<!-- Edit Status Modal -->
<div class="modal fade" id="editStatusModal{{ $order->id }}" tabindex="-1" aria-labelledby="editStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('order-manage.update-status', $order->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="editStatusModalLabel">Edit Order Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="status">Order Status</label>
                        <select name="status" class="form-control" required>
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

                                                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>

@endsection
