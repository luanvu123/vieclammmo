@extends('layouts.app')

@section('title', 'Quản lý khách hàng')

@section('content')

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <table id="user-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Mã KH</th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>SĐT</th>
                            <th>Số dư</th>
                            <th>Trạng thái</th>
                            <th>eKYC</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $customer)
                            <tr>
                                <td>{{ $customer->id }}</td>
                                <td>{{ $customer->idCustomer }}</td>
                                <td>{{ $customer->name }}
                                     @if ($customer->email == 'bgntmrqph24111516@vnetwork.io.vn')
        <i class="fa fa-check-circle" style="color:red; font-size: 80%;" title="Thuộc hệ thống"></i>
    @endif
                                </td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->phone }}</td>
                                <td>{{ number_format($customer->Balance) }} VNĐ</td>
                                <td>
                                    <span class="badge {{ $customer->Status ? 'badge-success' : 'badge-danger' }}">
                                        {{ $customer->Status ? 'Hoạt động' : 'Bị khóa' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $customer->isEkyc ? 'badge-success' : 'badge-warning' }}">
                                        {{ $customer->isEkyc ? 'Đã xác thực' : 'Chưa xác thực' }}
                                    </span>
                                </td>
                                <td>

                                    <a href="{{ route('customer-manage.edit', $customer->id) }}"
                                        class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i> Sửa
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


        </div>
    </div>
@endsection
