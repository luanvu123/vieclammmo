@extends('layouts.app')

@section('title', 'Danh sách Stock')

@section('content_header')
<h1>Danh sách file upload của {{ $variant->name }}</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <h1>Danh sách file upload của {{ $variant->name }}</h1>
        </h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered" id="user-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tên File</th>
                    <th>File</th>
                    <th>Success</th>
                    <th>Error</th>
                    <th>Trạng thái</th>
                    <th>UID</th>

                </tr>
            </thead>
            <tbody>
                @foreach($stocks as $key => $stock)
                    <tr>
                        <td>{{ $key }}</td>
                        <td>{{ basename($stock->file) }}</td>
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
                        <td>
                            @if($variant->type == "Tài khoản")
                                {{ $stock->uidFacebooks->count() }}
                                <a href="{{ route('stock.uid_index', $stock->id) }}">
                                    <i class="fas fa-eye"></i>UID
                                </a>
                            @elseif($variant->type == "Email")
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

@stop
