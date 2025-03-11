@extends('layouts.customer')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                        <h4 class="page-title">Quản lý Đơn hàng Dịch vụ</h4>
                        <div class="">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item active">Danh sách Đơn hàng Dịch vụ</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Danh sách Đơn hàng Dịch vụ</h4>
                        </div>
                        <div class="card-body pt-0">
                            <table class="table mb-0" id="datatable_1">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Mã đơn hàng</th>
                                        <th>Yêu cầu dịch vụ</th>
                                        <th>Người đặt hàng</th>
                                        <th>Ngày đặt</th>
                                        <th>Sản phẩm</th>
                                        <th>Biến thể sản phẩm</th>
                                        <th>Số lượng</th>
                                        <th>Tổng cộng</th>
                                        <th>Mã giảm giá</th>
                                        <th>Số tiền đã giảm</th>
                                        <th>Chiết khấu (4%)</th>
                                        <th>Trạng thái</th>
                                        <th class="text-end">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                                                    <tr>
                                                                        <td>{{ $order->id }}</td>
                                                                        <td>{{ $order->order_key }}</td>
                                                                        <td>{{ $order->required }}</td>
                                                                        <td>{{ $order->customer->name ?? 'Không tìm thấy người đặt hàng' }}</td>
                                                                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                                                        <td>{{ $order->productVariant->product->name ?? 'Không tìm thấy sản phẩm' }}</td>
                                                                        <td>{{ $order->productVariant->name ?? 'Không tìm thấy biến thể' }}</td>
                                                                        <td>{{ $order->quantity }}</td>
                                                                        <td>{{ number_format($order->total, 0, ',', '.') }}đ</td>
                                                                        <td>{{ $order->coupon->coupon_key ?? 'Không có' }}</td>
                                                                        <td>{{ number_format($order->discount_amount, 0, ',', '.') }}đ</td>
                                                                        <td>
                                                                            @php
                                                                                $discount = $order->total * 0.04;
                                                                            @endphp
                                                                            {{ number_format($discount, 0, ',', '.') }}đ
                                                                        </td>
                                                                        <td>
                                                                            <span
                                                                                class="badge bg-{{ $order->status == 'completed' ? 'success' : 'danger' }}">
                                                                                {{ ucfirst($order->status) }}
                                                                            </span>
                                                                        </td>
                                                                        <td class="text-end">
                                                                            <a href="{{ route('order-service.show', $order->id) }}"
                                                                                class="btn btn-primary btn-sm">Chi tiết</a>
                                                                        </td>
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
@endsection
