@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Danh Sách Danh Mục</h1>

        <a href="{{ route('categories.create') }}" class="btn btn-success mb-3">Thêm Danh Mục</a>

        <table class="table table-bordered" id="user-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Icon</th>
                    <th>Loại</th>
                    <th>Trạng Thái</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            @if($category->icon)
                                <img src="{{ asset('storage/' . $category->icon) }}" alt="Icon" width="50">
                            @endif
                        </td>
                        <td>{{ $category->type }}</td>
                        <td>{{ $category->status == 'active' ? 'Hoạt động' : 'Không hoạt động' }}</td>
                        <td>
                            <a href="{{ route('categories.show', $category->id) }}" class="btn btn-info">Xem</a>
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning">Sửa</a>
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

