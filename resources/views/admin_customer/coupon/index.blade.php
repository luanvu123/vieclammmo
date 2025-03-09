@extends('layouts.customer')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                        <h4 class="page-title">Quản lý mã giảm giá</h4>
                        <div class="">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('coupons.index') }}">Danh sách mã giảm giá</a>
                                </li>
                                <li class="breadcrumb-item active">Quản lý mã giảm giá</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h4 class="card-title">Danh sách mã giảm giá</h4>
                                </div>
                                <div class="col-auto">
                                    <a href="{{ route('coupons.create') }}" class="btn bg-primary text-white">
                                        <i class="fas fa-plus me-1"></i> Thêm mã giảm giá
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table class="table mb-0" id="datatable_1">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Mã giảm giá</th>
                                            <th>Sản phẩm</th>
                                            <th>Loại</th>
                                            <th>Giảm giá (%)</th>
                                            <th>Giá trị</th>
                                            <th>Trạng thái</th>
                                            <th class="text-end">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($coupons as $coupon)
                                            <tr>
                                                <td>{{ $coupon->id }}</td>
                                                <td>{{ $coupon->coupon_key }}</td>
                                                <td>{{ $coupon->product->name }}</td>
                                                <td>{{ ucfirst($coupon->type) }}</td>
                                                <td>
                                                    @if ($coupon->type == 'percent')
                                                        {{ $coupon->percent }}%
                                                    @else
                                                        ---
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($coupon->type == 'fixed')
                                                        {{ number_format($coupon->max_amount, 0, ',', '.') }}đ
                                                    @else
                                                        ---
                                                    @endif
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge bg-{{ $coupon->status == 'active' ? 'success' : 'danger' }}">
                                                        {{ ucfirst($coupon->status) }}
                                                    </span>
                                                </td>
                                                <td class="text-end">
                                                    <a href="{{ route('coupons.edit', $coupon->id) }}"
                                                        class="btn btn-warning btn-sm">Sửa</a>
                                                    <form action="{{ route('coupons.destroy', $coupon->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                                                    </form>
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
