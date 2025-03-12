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
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $order->order_key }}</td>
                        <td>{{ $order->customer->name }}</td>
                        <td>
                            <a href="{{ route('messages.create', ['customerId' => $order->productVariant->product->customer_id]) }}">
                                {{ $order->productVariant->product->customer->name }}
                            </a>
                        </td>
                        <td>{{ number_format($order->total, 0, ',', '.') }} VND</td>
                        <td>{{ $order->status }}</td>
                    </tr>
                </tbody>
            </table>

            <h3>Chi tiết sản phẩm</h3>
            <table class="table table-bordered" id="user-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tài khoản</th>
                        <th>Giá trị</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderDetails as $key=> $detail)
                        <tr>
                            <td>{{$key}}</td>
                            <td>{{ $detail->account }}</td>
                            <td>{{ $detail->value }}</td>
                            <td>{{ $detail->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
