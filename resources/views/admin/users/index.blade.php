@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h1>Danh Sách Người Dùng</h1>
                <a href="{{ route('users.create') }}" class="btn btn-success mb-3">Thêm Người Dùng</a>

                <table class="table table-bordered" id="user-table">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Ảnh</th>
                            <th>Trạng Thái</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if ($user->image)
                                        <img src="{{ asset('storage/' . $user->image) }}" width="50" height="50"
                                            class="rounded-circle">
                                    @else
                                        Không có ảnh
                                    @endif
                                </td>
                                <td>{{ $user->status == 'active' ? 'Hoạt động' : 'Không hoạt động' }}</td>
                                <td>
                                    <a href="{{ route('users.show', $user) }}" class="btn btn-info btn-sm">Xem</a>
                                    <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm">Sửa</a>
                                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
  
@endsection
