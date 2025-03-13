@extends('layouts.app')

@section('title', 'Danh sách khách hàng')

@section('content_header')
    <h1>Danh sách Khách hàng</h1>
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <h1> Đăng kí bán hàng</h1>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="user-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tên khách hàng</th>
                            <th>Email</th>
                            <th>Số tài khoản</th>
                            <th>Facebook</th>
                            <th>Số điện thoại</th>
                            <th>Người bán</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $key => $customer)
                            <tr>


                                        <td>{{ $key + 1 }}
            @if($customer->updated_at->diffInHours(now()) <= 24 && $customer->account_number)
                <span class="badge badge-primary">New</span>
            @endif
        </td>





                                <td>   <a href="{{ route('messages.create', ['customerId' => $customer->id]) }}"
                                        class="text-primary">
                                        {{ $customer->name }}
                                    </a></td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->account_number ?? 'Không có' }}</td>
                                <td>
                                    @if ($customer->url_facebook)
                                        <a href="{{ $customer->url_facebook }}" target="_blank">Xem Facebook</a>
                                    @else
                                        Không có
                                    @endif
                                </td>
                                <td>{{ $customer->phone ?? 'Không có' }}</td>
                                <td>
                                    @if ($customer->isSeller)
                                        <span class="badge badge-success">Đã là người bán</span>
                                    @else
                                        <span class="badge badge-danger">Chưa là người bán</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('admin.customers.updateIsseller', $customer->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            {{ $customer->isSeller ? 'Hủy người bán' : 'Cấp quyền người bán' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

