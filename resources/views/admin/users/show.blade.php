@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Thông Tin Người Dùng</h1>

        <div class="card">
            <div class="card-header">
                <h4>{{ $user->name }}</h4>
            </div>
            <div class="card-body">
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Mô tả:</strong> {!! $user->description !!}</p>
                <p><strong>Trạng thái:</strong>
                    <span class="badge {{ $user->status == 'active' ? 'badge-success' : 'badge-secondary' }}">
                        {{ $user->status == 'active' ? 'Hoạt động' : 'Không hoạt động' }}
                    </span>
                </p>
                <p><strong>Ảnh đại diện:</strong></p>
                @if ($user->image)
                    <img src="{{ asset('storage/' . $user->image) }}" width="150">
                @else
                    <p>Không có ảnh</p>
                @endif
            </div>
            <div class="card-footer">
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">Chỉnh sửa</a>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Quay lại</a>
            </div>
        </div>
    </div>
@endsection
