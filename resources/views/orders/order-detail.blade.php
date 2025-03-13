@extends('layouts.customer')

@section('content')

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                        <h4 class="page-title">Danh sách sản phẩm của đơn hàng {{$order->productVariant->name}}</h4>
                        <div class="">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item active">{{$order->productVariant->name}}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{$order->productVariant->name}}</h4>
                            {{$order->productVariant->expiry}}, {{$order->productVariant->url}}
                        </div>
                        <div class="card-body pt-0">
                            <div class="table-responsive">


                                @if($order->orderDetails->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table mb-0" id="datatable_1">
                                            <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Tài khoản/Email</th>
                                                    <th>Giá trị</th>
                                                    <th>Trạng thái</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($order->orderDetails as $index => $detail)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $detail->account }}</td>
                                                        <td>{{$detail->value}}</td>
                                                        <td>
                                                            @if($detail->status == 'success')
                                                                <span class="badge bg-success">Thành công</span>
                                                            @elseif($detail->status == 'error')
                                                                <span class="badge bg-danger">Lỗi</span>
                                                            @else
                                                                <span class="badge bg-warning">Bảo hành</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @elseif($order->productVariant->type == "Dịch vụ")
                                    <div class="alert alert-info">
                                        <p>Đây là đơn hàng yêu cầu dịch vụ. Người bán sẽ liên hệ với bạn để thực hiện.</p>
                                    </div>
                                @else
                                    <div class="alert alert-warning">
                                        <p>Chưa có dữ liệu chi tiết cho đơn hàng này.</p>
                                    </div>
                                @endif

                                <a href="{{ route('order-manage.index') }}" class="btn btn-secondary mt-3">Quay lại</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
