@extends('layouts.app')

@section('title', 'Danh sách chi tiết đơn hàng')

@section('content')
    <div class="container-fluid">
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">Danh sách chi tiết đơn hàng</h3>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover" id="user-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Mã đơn hàng</th>
                            <th>Người mua</th>
                            <th>Người bán</th>
                            <th>Tài khoản</th>
                            <th>Giá trị</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orderDetails as $key => $orderDetail)
                            <tr>
                                <td>{{ $key }}</td>
                                <td>

                                     <a href="{{ route('admin.order_detail.index', $orderDetail->order->id) }}">
                                         {{ $orderDetail->order->order_key }}
                                    </a>
                                    @if (\Carbon\Carbon::parse($orderDetail->created_at)->greaterThanOrEqualTo(\Carbon\Carbon::now()->subDay()))
                                        <span class="label label-primary pull-right">New</span>
                                    @endif
                                </td>

                                <td>

                                    <a
                                        href="{{ route('messages.create', ['customerId' => $orderDetail->order->customer_id]) }}">
                                      {{ $orderDetail->order->customer->name }}
                                    </a>
                                </td>
                                <td>
                                    <a
                                        href="{{ route('messages.create', ['customerId' => $orderDetail->order->productVariant->product->customer_id]) }}">
                                        {{ $orderDetail->order->productVariant->product->customer->name }}
                                    </a>
                                </td>
                                <td>{{ $orderDetail->account }}</td>
                                <td>{{$orderDetail->value}}</td>
                                <td>
                                    @if ($orderDetail->status === 'success')
                                        <span class="badge badge-success">Hoàn thành</span>
                                    @elseif($orderDetail->status ==='error')
                                        <span class="badge badge-error">Lỗi</span>
                                        @else
                                         <span class="badge badge-warning">BH</span>
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
