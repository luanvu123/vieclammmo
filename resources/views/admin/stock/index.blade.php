@extends('layouts.app')

@section('title', 'Danh sách Stock')

@section('content_header')
    <h1>Danh sách Stock của {{ $variant->name }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Danh sách Stock</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>File</th>
                        <th>Số lượng thành công</th>
                        <th>Số lượng lỗi</th>
                        <th>Trạng thái</th>
                        <th>UID Facebook</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stocks as $stock)
                        <tr>
                            <td>{{ $stock->id }}</td>
                            <td>
                                @if($stock->file)
                                    <a href="{{ asset('storage/' . $stock->file) }}" target="_blank">Xem file</a>
                                @else
                                    Không có file
                                @endif
                            </td>
                            <td>{{ $stock->quantity_success }}</td>
                            <td>{{ $stock->quantity_error }}</td>
                            <td>
                                @if($stock->status == 'active')
                                    <span class="badge badge-success">Đã check</span>
                                @else
                                    <span class="badge badge-danger">Chưa check</span>
                                @endif
                            </td>
                            <td>{{ $stock->uidFacebooks->count() }} UID</td>
                            <td>
                                <a href="{{ route('stock.uid_index', $stock->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Xem UID
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
