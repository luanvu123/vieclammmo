@extends('layouts.app')

@section('title', 'Danh sách đơn hàng')

@section('content_header')
    <h1>Danh sách đơn hàng</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered" id="user-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Order Key</th>
                        <th>Người mua</th>
                        <th>Người bán</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $key=> $order)
                        <tr>
                            <td>{{$key}}</td>
                            <td>{{ $order->order_key }}</td>
                            <td>{{ $order->customer->name }}</td>
                            <td>
                                <a href="{{ route('messages.create', ['customerId' => $order->productVariant->product->customer_id]) }}">
                                    {{ $order->productVariant->product->customer->name }}
                                </a>
                            </td>
                            <td>{{ number_format($order->total, 0, ',', '.') }} VND</td>
                            <td>{{ $order->status }}</td>
                            <td>
                                <a href="{{ route('admin.order_detail.index', $order->id) }}" class="btn btn-primary">Xem chi tiết</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
