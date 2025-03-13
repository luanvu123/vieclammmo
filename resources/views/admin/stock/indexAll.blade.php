@extends('layouts.app')

@section('title', 'All Stocks')

@section('content_header')
<h1>All Stocks</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="user-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên shop</th>
                        <th>Mặt hàng</th>
                        <th>Tên File</th>
                        <th>File</th>
                        <th>thành công</th>
                        <th>lỗi</th>
                        <th>Ngày up</th>
                        <th>Hành động</th>
                        <th>UID</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stocks as $key => $stock)
                        <tr>
                            <th>
                                {{ $key + 1 }}
                                @if ($stock->created_at >= \Carbon\Carbon::now()->subDay())
                                    <span class="label label-primary pull-right">New</span>
                                @endif
                            </th>
                            <td><a
                                    href="{{ route('messages.create', ['customerId' => $stock->productVariant->product->customer_id]) }}">
                                    {{ $stock->productVariant->product->customer->name ?? 'N/A' }}
                                </a>

                            </td>
                            <td>
                                @if ($stock->productVariant && $stock->productVariant->product)
                                    <a
                                        href="{{ route('product-variants.list', ['product' => $stock->productVariant->product_id]) }}">
                                        {{ $stock->productVariant->name }}
                                    </a>
                                @else
                                    N/A
                                @endif
                            </td>

                            <td>{{ basename($stock->file) }}</td> {{-- Hiển thị tên file --}}
                            <td>
                                @if($stock->file)
                                    <a href="{{ asset('storage/' . $stock->file) }}" target="_blank">Xem file</a>
                                @else
                                    Không có file
                                @endif
                            </td>
                            <td>{{ $stock->quantity_success }}</td>
                            <td>{{ $stock->quantity_error }}</td>
                            <td>{{$stock->created_at}}</td>
                            <td>
                                @if($stock->status == 'active')
                                    <span class="badge badge-success">Đã check</span>
                                @else
                                    <span class="badge badge-danger">Chưa check</span>
                                @endif
                            </td>
                            <td>
                                @if($stock->productVariant->type == "Tài khoản")
                                    {{ $stock->uidFacebooks->count() }}
                                    <a href="{{ route('stock.uid_index', $stock->id) }}">
                                        <i class="fas fa-eye"></i>UID
                                    </a>
                                @elseif($stock->productVariant->type == "Email")
                                    {{ $stock->uidEmails->count() }}
                                    <a href="{{ route('stock.uid_email_index', $stock->id) }}">
                                        <i class="fas fa-envelope"></i>UID
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop
