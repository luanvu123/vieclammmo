@extends('layouts.app')

@section('title', 'Danh sách UID Facebook')

@section('content_header')
<h1>Danh sách UID Facebook của Stock ID: {{ $stock->id }}</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <a href="{{ route('stock.uid_create', $stock->id) }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Thêm UID Email
        </a>
    </div>
    <div class="card-body">
        <table class="table table-bordered" id="email-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Giá trị</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th> <!-- Thêm cột Ngày tạo -->
                </tr>
            </thead>
            <tbody>
                @foreach($stock->uidEmails as $email)
                    <tr>
                        <td>{{ $email->id }}</td>
                        <td>{{ $email->email }}</td>
                        <td>{{ $email->value }}</td>
                        <td>
                            @if($email->status == 'active')
                                <span class="badge badge-success">Hoạt động</span>
                            @else
                                <span class="badge badge-danger">Không hoạt động</span>
                            @endif
                        </td>
                        <td>{{ $email->created_at->format('d/m/Y H:i') }}</td> <!-- Hiển thị ngày tạo -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <a href="{{ route('stock-manage.index', $stock->productVariant->id) }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Quay lại file upload
    </a>
</div>

@stop
