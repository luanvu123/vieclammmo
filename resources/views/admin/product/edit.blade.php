@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Chỉnh sửa sản phẩm</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('product-manage.update', $product) }}" method="POST">

                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Tên sản phẩm -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tên sản phẩm</label>
                            <input type="text" class="form-control" value="{{ $product->name }}" readonly>
                        </div>
                    </div>

                    <!-- Danh mục -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Danh mục</label>
                            <input type="text" class="form-control" value="{{ $product->category->name ?? 'Không có' }}" readonly>
                        </div>
                    </div>

                    <!-- Danh mục con -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Danh mục con</label>
                            <input type="text" class="form-control" value="{{ $product->subcategory->name ?? 'Không có' }}" readonly>
                        </div>
                    </div>

                    <!-- Khách hàng -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Khách hàng</label>
                            <input type="text" class="form-control" value="{{ $product->customer->name ?? 'Không có' }}" readonly>
                        </div>
                    </div>

                    <!-- Hình ảnh -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Hình ảnh</label>
                            <div>
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="80">
                                @else
                                    <p>Không có ảnh</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Mô tả ngắn -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Mô tả ngắn</label>
                            <input type="text" class="form-control" value="{{ $product->short_description }}" readonly>
                        </div>
                    </div>

                    <!-- Hoàn tiền (%) -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Hoàn tiền (%)</label>
                            <input type="text" class="form-control" value="{{ $product->cashback_percentage }}%" readonly>
                        </div>
                    </div>

                    <!-- Mô tả -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Mô tả</label>
                            <textarea class="form-control" rows="3" readonly>{{ $product->description }}</textarea>
                        </div>
                    </div>

                    <!-- Slug -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" class="form-control" value="{{ $product->slug }}" readonly>
                        </div>
                    </div>

                    <!-- Trạng thái -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Trạng thái</label>
                            <select name="status" class="form-control">
                                <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Hoạt động</option>
                                <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
                            </select>
                        </div>
                    </div>

                    <!-- Sản phẩm nổi bật -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Sản phẩm nổi bật</label>
                            <select name="is_hot" class="form-control">
                                <option value="1" {{ $product->is_hot ? 'selected' : '' }}>Nổi bật</option>
                                <option value="0" {{ !$product->is_hot ? 'selected' : '' }}>Bình thường</option>
                            </select>
                        </div>
                    </div>

                </div>

                <button type="submit" class="btn btn-success">Cập nhật</button>
                <a href="{{ route('product-manage.index') }}" class="btn btn-secondary">Quay lại</a>
            </form>
        </div>
    </div>
</div>
@endsection
