@extends('layouts.app')

@section('title', 'Quản lý Bài viết')

@section('content_header')
    <h1>Quản lý Bài viết</h1>
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered" id="user-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên bài viết</th>
                <th>Ảnh</th>
                <th>Mô tả</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
                <tr>
                    <td>{{ $post->id }}
                        @if (\Carbon\Carbon::parse($post->created_at)->greaterThanOrEqualTo(\Carbon\Carbon::now()->subDay()))
        <span class="label label-primary pull-right">New</span>
    @endif
                    </td>
                    <td>{{ $post->name }}</td>
                    <td><img src="{{ asset('storage/' . $post->image) }}" alt="Image" width="100"></td>
                    <td>{!! Str::limit($post->description, 50) !!}</td>
                    <td>{{ $post->status ? 'Hoạt động' : 'Không hoạt động' }}</td>
                    <td>
                        <a href="{{ route('post-manage.edit', $post->id) }}" class="btn btn-primary btn-sm">Sửa</a>
                        <form action="{{ route('post-manage.destroy', $post->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa bài viết này?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
