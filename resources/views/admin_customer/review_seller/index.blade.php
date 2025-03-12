@extends('layouts.customer')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                        <h4 class="page-title">Quản lý đánh giá</h4>
                        <div class="">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('review-manage.index') }}">Danh sách đánh giá</a></li>
                                <li class="breadcrumb-item active">Quản lý đánh giá</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Danh sách đánh giá</h4>
                        </div>
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table class="table mb-0" id="datatable_1">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Khách hàng</th>
                                            <th>Đơn hàng</th>
                                            <th>Sản phẩm</th>
                                            <th>Đánh giá</th>
                                            <th>Nội dung</th>
                                            <th>Trạng thái chất lượng</th>
                                            <th class="text-end">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reviews as $key=> $review)
                                            <tr>
                                               <th>
    {{$key}}
    @if (\Carbon\Carbon::parse($review->created_at)->greaterThanOrEqualTo(\Carbon\Carbon::now()->subDay()))
        <span class="badge text-bg-info ms-auto">New</span>
    @endif
</th>
                                                <td><a href="{{ route('messages.create', ['customerId' => $review->customer_id]) }}">
                                 {{ $review->customer->name}}
                            </a></td>
                                                <td><a
                                                                                        href="{{ route('order-detail.show', $review->order->id) }}">{{ $review->order->order_key }}</a></td>
                                                <td>{{ $review->product->name ?? 'N/A' }}</td>
                                                <td>{{ $review->rating }} / 5</td>
                                                <td>{{ Str::limit($review->content, 50) }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $review->quality_status == 'approved' ? 'success' : 'warning' }}">
                                                        {{ ucfirst($review->quality_status) }}
                                                    </span>
                                                </td>
                                                <td class="text-end">

                                                    <form action="{{ route('review-manage.destroy', $review->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
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
