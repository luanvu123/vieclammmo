@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Danh Sách Thể Loại Bài Viết</h1>
    <a href="{{ route('genre_posts.create') }}" class="btn btn-primary mb-3">Thêm thể loại</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table" id="user-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Trạng Thái</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($genrePosts as $genrePost)
            <tr>
                <td>{{ $genrePost->id }}</td>
                <td>{{ $genrePost->name }}</td>
                <td>{{ $genrePost->status }}</td>
                <td>
                    <a href="{{ route('genre_posts.edit', $genrePost->id) }}" class="btn btn-warning">Sửa</a>
                    <form action="{{ route('genre_posts.destroy', $genrePost->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Xóa thể loại này?')">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
