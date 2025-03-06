@extends('layouts.app')

@section('title', 'Danh sách hỗ trợ')

@section('content_header')
    <h1>Danh sách hỗ trợ</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered" id="user-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Chủ đề</th>
                        <th>Nội dung</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($supports as $support)
                        <tr>
                            <td>{{ $support->id }}</td>
                            <td>{{ $support->email }}</td>
                            <td>{{ $support->phone }}</td>
                            <td>{{ $support->subject }}</td>
                            <td>{{ $support->message }}</td>
                            <td>
                                <span class="badge {{ $support->status == 'Đã phản hồi' ? 'badge-success' : 'badge-warning' }}">
                                    {{ $support->status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('supports.edit', $support->id) }}" class="btn btn-primary btn-sm">Chỉnh sửa</a>
                                <form action="{{ route('supports.destroy', $support->id) }}" method="POST" style="display:inline-block;">
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
@stop
