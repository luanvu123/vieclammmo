@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Chỉnh Sửa SubCategory</h1>

        <form action="{{ route('subcategories.update', $subcategory->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Tên SubCategory</label>
                <input type="text" name="name" class="form-control" value="{{ $subcategory->name }}">
                @error('name')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="category_id">Chọn Category</label>
                <select name="category_id" class="form-control">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $subcategory->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="status">Trạng Thái</label>
                <select name="status" class="form-control">
                    <option value="active" {{ $subcategory->status == 'active' ? 'selected' : '' }}>Hoạt động</option>
                    <option value="inactive" {{ $subcategory->status == 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Cập Nhật</button>
        </form>
    </div>
@endsection
