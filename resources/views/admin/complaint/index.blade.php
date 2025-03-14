@extends('layouts.app')

@section('title', 'Danh sách Khiếu nại')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Danh sách Khiếu nại</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover" id="user-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Khách hàng</th>
                            <th>Đơn hàng</th>
                            <th>Nội dung</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($complaints as $complaint)
                            <tr>
                                <td>{{ $complaint->id }}
                                    @if (\Carbon\Carbon::parse($complaint->created_at)->greaterThanOrEqualTo(\Carbon\Carbon::now()->subDay()))
                                        <span class="label label-primary pull-right">New</span>
                                    @endif
                                </td>
                                   <td>   <a href="{{ route('messages.create', ['customerId' => $complaint->customer_id]) }}"
                                        class="text-primary">
                                        {{ $complaint->customer->name }}
                                    </a></td>

                            <td><a
                                                                                        href="{{ route('admin.order_detail.index', $complaint->order->id) }}">{{ $complaint->order->order_key }}</td>
                                <td>{{ $complaint->content }}</td>
                                <td>
                                    @if($complaint->status === 'pending')
                                        <span class="badge badge-warning">Đang chờ xử lý</span>
                                    @elseif($complaint->status === 'resolved')
                                        <span class="badge badge-success">Đã giải quyết</span>
                                    @else
                                        <span class="badge badge-danger">Đã hủy</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="#" class="btn btn-primary btn-sm">Xem</a>
                                    <a href="#" class="btn btn-danger btn-sm">Xóa</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection
