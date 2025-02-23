@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Chỉnh Sửa Người Dùng</h1>

        <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Tên người dùng</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                @error('name')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" readonly>
            </div>

            <div class="form-group">
                <label for="description">Mô tả</label>
                <textarea name="description" id="summary2" class="form-control">{{ old('description', $user->description) }}</textarea>
                @error('description')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="image">Ảnh đại diện</label>
                <input type="file" name="image" class="form-control">
                @if ($user->image)
                    <img src="{{ asset('storage/' . $user->image) }}" width="100" class="mt-2">
                @endif
                @error('image')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="status">Trạng thái</label>
                <select name="status" class="form-control">
                    <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Hoạt động</option>
                    <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Cập Nhật</button>
        </form>
    </div>
@endsection
