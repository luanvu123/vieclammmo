@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Thêm Danh Mục</h1>

        <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Tên Danh Mục</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                @error('name')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="icon">Icon</label>
                <input type="file" name="icon" class="form-control">
                @error('icon')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="type">Loại Danh Mục</label>
                <select name="type" class="form-control">
                    <option value="Sản phẩm">Sản phẩm</option>
                    <option value="Dịch vụ">Dịch vụ</option>
                </select>
                @error('type')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Mô Tả</label>
                <textarea name="description" id="summary4" class="form-control" rows="4"></textarea>
                @error('description')
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

            <button type="submit" class="btn btn-primary mt-3">Tạo</button>
        </form>
    </div>
@endsection
