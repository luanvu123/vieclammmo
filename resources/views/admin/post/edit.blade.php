@extends('layouts.app')

@section('title', 'Chỉnh sửa Bài viết')

@section('content_header')
    <h1>Chỉnh sửa Bài viết</h1>
@stop

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('post-manage.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Tên bài viết:</label>
            <input type="text" name="name" value="{{ $post->name }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="slug">Slug:</label>
            <input type="text" name="slug" value="{{ $post->slug }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="image">Hình ảnh:</label>
            <input type="file" name="image" class="form-control">
            @if ($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" alt="Image" width="100">
            @endif
        </div>

        <div class="form-group">
            <label for="description">Mô tả:</label>
            <textarea name="description" class="form-control" rows="5" required>{!! $post->description !!}</textarea>
        </div>

        <div class="form-group">
            <label for="status">Trạng thái:</label>
            <select name="status" class="form-control" required>
                <option value="1" {{ $post->status ? 'selected' : '' }}>Hoạt động</option>
                <option value="0" {{ !$post->status ? 'selected' : '' }}>Không hoạt động</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Cập nhật</button>
        <a href="{{ route('post-manage.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
@endsection
