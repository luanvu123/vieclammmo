@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Chi Tiết SubCategory</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Tên: {{ $subcategory->name }}</h5>
                <p class="card-text">Thuộc Category: {{ $subcategory->category->name }}</p>
                <p class="card-text">Trạng Thái: {{ $subcategory->status == 'active' ? 'Hoạt động' : 'Không hoạt động' }}</p>
                <a href="{{ route('subcategories.edit', $subcategory->id) }}" class="btn btn-primary">Chỉnh Sửa</a>
                <a href="{{ route('subcategories.index') }}" class="btn btn-secondary">Quay Lại</a>
            </div>
        </div>
    </div>
@endsection
