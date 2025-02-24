@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Chi Tiết Danh Mục</h1>

        <div class="card">
            <div class="card-body">
                <h3>{{ $category->name }}</h3>
                <p><strong>Slug:</strong> {{ $category->slug }}</p>
                <p><strong>Loại:</strong> {{ $category->type }}</p>
                <p><strong>Trạng Thái:</strong> {{ $category->status == 'active' ? 'Hoạt động' : 'Không hoạt động' }}</p>
                @if($category->icon)
                    <p><strong>Icon:</strong></p>
                    <img src="{{ asset('storage/' . $category->icon) }}" alt="Icon" width="100">
                @endif
            </div>
        </div>

        <a href="{{ route('categories.index') }}" class="btn btn-secondary mt-3">Quay lại</a>
    </div>
@endsection

