@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Thêm SubCategory</h1>

        <form action="{{ route('subcategories.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Tên SubCategory</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                @error('name')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="category_id">Chọn Category</label>
                <select name="category_id" class="form-control">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="status">Trạng Thái</label>
                <select name="status" class="form-control">
                    <option value="active">Hoạt động</option>
                    <option value="inactive">Không hoạt động</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Tạo mới</button>
        </form>
    </div>
@endsection
