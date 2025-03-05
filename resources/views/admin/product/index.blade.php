@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Danh sách sản phẩm</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered" id="user-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên sản phẩm</th>
                        <th>Danh mục</th>
                        <th>Danh mục con</th>
                        <th>Khách hàng</th>
                        <th>Hình ảnh</th>
                        <th>Mô tả ngắn</th>
                        <th>Hoàn tiền (%)</th>
                        <th>Slug</th>
                        <th>Trạng thái</th>
                        <th>Nổi bật</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name ?? 'Không có' }}</td>
                        <td>{{ $product->subcategory->name ?? 'Không có' }}</td>
                        <td>{{ $product->customer->name ?? 'Không có' }}</td>
                        <td>
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="60">
                            @else
                                Không có
                            @endif
                        </td>
                        <td>{{ Str::limit($product->short_description, 50) }}</td>
                        <td>{{ $product->cashback_percentage }}%</td>

                        <td>{{ $product->slug }}</td>
                        <td>
                            <span class="badge {{ $product->status == 'active' ? 'badge-success' : 'badge-danger' }}">
                                {{ $product->status == 'active' ? 'Hoạt động' : 'Không hoạt động' }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $product->is_hot ? 'badge-warning' : 'badge-secondary' }}">
                                {{ $product->is_hot ? 'Nổi bật' : 'Bình thường' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('product-manage.edit', $product->id) }}" class="btn btn-primary btn-sm">Chỉnh sửa</a>
                                <a href="{{ route('product-variants.list', $product->id) }}" class="btn btn-warning btn-sm">Mặt hàng</a>
                            <form action="{{ route('product-manage.destroy', $product->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
@endsection
