@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Thêm Thể Loại Bài Viết</h1>

    <form action="{{ route('genre_posts.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Tên</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            @error('name')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="status">Trạng Thái</label>
            <select name="status" class="form-control">
                <option value="active">Hoạt động</option>
                <option value="inactive">Không hoạt động</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Thêm</button>
    </form>
</div>
@endsection
