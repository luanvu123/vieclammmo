@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng')

@section('content_header')
<h1>Chi tiết đơn hàng</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Order Key</th>
                    <th>Người mua</th>
                    <th>Người bán</th>
                    <th>Y/c</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $order->order_key }}</td>
                    <td>{{ $order->customer->name }}</td>
                    <td>
                        <a
                            href="{{ route('messages.create', ['customerId' => $order->productVariant->product->customer_id]) }}">
                            {{ $order->productVariant->product->customer->name }}
                        </a>
                    </td>
                    <td>{{$order->required}}</td>
                    <td>{{ number_format($order->total, 0, ',', '.') }} VND</td>
                    <td>{{ $order->status }}</td>
                </tr>
            </tbody>
        </table>

        @if($order->productVariant->product->category->type == "Sản phẩm")
            <h3>Chi tiết sản phẩm</h3>
            <table class="table table-bordered" id="user-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tài khoản</th>
                        <th>Giá trị</th>
                        <th>Trạng thái</th>
                        @if($order->productVariant->url)
                            <th>URL</th>
                        @endif
                        @if($order->productVariant->expiry)
                            <th>Hạn sử dụng</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderDetails as $key => $detail)
                        <tr>
                            <td>{{$key}}</td>
                            <td>{{ $detail->account }}</td>
                            <td>{{ $detail->value }}</td>
                            <td>{{ $detail->status }}</td>
                            @if($order->productVariant->url)
                                <td><a href="{{ $order->productVariant->url }}" target="_blank">Xem</a></td>
                            @endif
                            @if($order->productVariant->expiry)
                                <td>{{ $order->productVariant->expiry }}</td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@stop
