@extends('layouts.app')

@section('title', 'Danh sách đơn hàng')

@section('content_header')
<h1>Danh sách đơn hàng</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <h1>Danh sách đơn hàng</h1>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="user-table">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Order Key</th>
                        <th>Người mua</th>
                        <th>Người bán</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th>Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $key => $order)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>

                                <a href="{{ route('admin.order_detail.index', $order->id) }}">{{ $order->order_key }}
                                    @if (\Carbon\Carbon::parse($order->created_at)->greaterThanOrEqualTo(\Carbon\Carbon::now()->subDay()))
                                        <span class="badge badge-primary ml-2">New</span>
                                    @endif
                            </td>
                            <td>
                                <a href="{{ route('messages.create', ['customerId' => $order->customer_id]) }}"
                                    class="text-primary">
                                    {{ $order->customer->name }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('messages.create', ['customerId' => $order->productVariant->product->customer_id]) }}"
                                    class="text-primary">
                                    {{ $order->productVariant->product->customer->name }}
                                </a>
                            </td>
                            <td>{{ number_format($order->total, 0, ',', '.') }} VND</td>
                            <td>
                                @if ($order->status == 'pending')
                                    <span class="badge badge-warning">Đang chờ</span>
                                @elseif ($order->status == 'completed')
                                    <span class="badge badge-success">Hoàn thành</span>
                                @elseif ($order->status == 'canceled')
                                    <span class="badge badge-danger">Đã hủy</span>
                                @else
                                    <span class="badge badge-secondary">{{ ucfirst($order->status) }}</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.order_detail.index', $order->id) }}" class="btn btn-info btn-sm">
                                    Xem chi tiết
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop
