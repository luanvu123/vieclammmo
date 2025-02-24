@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Chỉnh Sửa Danh Mục</h1>

        <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Tên Danh Mục</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
                @error('name')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="icon">Icon</label>
                <input type="file" name="icon" class="form-control">
                @if($category->icon)
                    <img src="{{ asset('storage/' . $category->icon) }}" alt="Icon" width="100">
                @endif
                @error('icon')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="type">Loại Danh Mục</label>
                <select name="type" class="form-control">
                    <option value="Sản phẩm" {{ $category->type == 'product' ? 'selected' : '' }}>Sản phẩm</option>
                    <option value="Dịch vụ" {{ $category->type == 'service' ? 'selected' : '' }}>Dịch vụ</option>
                </select>
                @error('type')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
<div class="form-group">
    <label for="description">Mô Tả</label>
    <textarea name="description" id="summary4" class="form-control" rows="4">{{ old('description', isset($category) ? $category->description : '') }}</textarea>
    @error('description')
        <div class="alert alert-danger mt-2">{{ $message }}</div>
    @enderror
</div>

            <div class="form-group">
                <label for="status">Trạng Thái</label>
                <select name="status" class="form-control">
                    <option value="active" {{ $category->status == 'active' ? 'selected' : '' }}>Hoạt động</option>
                    <option value="inactive" {{ $category->status == 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Cập Nhật</button>
        </form>
    </div>
@endsection

