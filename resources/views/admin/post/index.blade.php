@extends('layouts.app')

@section('title', 'Quản lý Bài viết')

@section('content_header')
    <h1>Quản lý Bài viết</h1>
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="user-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên bài viết</th>
                            <th>Ảnh</th>
                            <th>Mô tả</th>
                            <th>Khách hàng</th>
                            <th>Thể loại</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $post)
                            <tr>
                                <td>
                                    {{ $post->id }}
                                    @if (\Carbon\Carbon::parse($post->created_at)->greaterThanOrEqualTo(\Carbon\Carbon::now()->subDay()))
                                        <span class="badge badge-primary ml-2">New</span>
                                    @endif
                                </td>
                                <td>{{ $post->name }}</td>
                                <td><img src="{{ asset('storage/' . $post->image) }}" alt="Image" width="100"></td>
                                <td>{!! Str::limit($post->description, 50) !!}</td>
                                <td>

                                       <a href="{{ route('messages.create', ['customerId' => $post->customer_id]) }}"
                                        class="text-primary">
                                        {{ $post->customer->name }}
                                    </a>
                                </td>
                                <td>{{ $post->genrePost->name ?? 'Không xác định' }}</td>
                                <td>
                                    @if ($post->status)
                                        <span class="badge badge-success">Hoạt động</span>
                                    @else
                                        <span class="badge badge-danger">Không hoạt động</span>
                                    @endif
                                </td>
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
            </div>
        </div>
    </div>
@endsection
