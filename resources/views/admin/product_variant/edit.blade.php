@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Chỉnh sửa Biến thể</h2>
    <form action="{{ route('product-variant-manage.update', $productVariant) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Tên</label>
            <input type="text" name="name" value="{{ $productVariant->name }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Giá</label>
            <input type="number" name="price" value="{{ $productVariant->price }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Trạng thái</label>
            <select name="status" class="form-control">
                <option value="active" {{ $productVariant->status == 'active' ? 'selected' : '' }}>Hoạt động</option>
                <option value="inactive" {{ $productVariant->status == 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Lưu</button>
    </form>
</div>
@endsection
