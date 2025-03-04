@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Chỉnh Sửa Thể Loại</h1>

    <form action="{{ route('genre_posts.update', $genrePost->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Tên</label>
            <input type="text" name="name" class="form-control" value="{{ $genrePost->name }}" required>
        </div>

        <div class="form-group">
            <label for="status">Trạng Thái</label>
            <select name="status" class="form-control">
                <option value="active" {{ $genrePost->status == 'active' ? 'selected' : '' }}>Hoạt động</option>
                <option value="inactive" {{ $genrePost->status == 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success mt-3">Cập Nhật</button>
    </form>
</div>
@endsection
