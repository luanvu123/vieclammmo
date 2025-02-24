@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Danh Sách SubCategory</h1>
        <a href="{{ route('subcategories.create') }}" class="btn btn-success mb-3">Thêm SubCategory</a>

        <table class="table table-bordered" id="user-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên SubCategory</th>
                    <th>Thuộc Category</th>
                    <th>Trạng Thái</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subcategories as $subcategory)
                    <tr>
                        <td>{{ $subcategory->id }}</td>
                        <td>{{ $subcategory->name }}</td>
                        <td>{{ $subcategory->category->name }}</td>
                        <td>{{ $subcategory->status == 'active' ? 'Hoạt động' : 'Không hoạt động' }}</td>
                        <td>
                            <a href="{{ route('subcategories.show', $subcategory->id) }}" class="btn btn-info">Xem</a>
                            <a href="{{ route('subcategories.edit', $subcategory->id) }}" class="btn btn-primary">Sửa</a>
                            <form action="{{ route('subcategories.destroy', $subcategory->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
