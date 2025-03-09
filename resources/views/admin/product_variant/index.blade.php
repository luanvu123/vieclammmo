@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Danh sách biến thể</h3>
        <div class="card-tools">
            <a href="{{ route('product-manage.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Quay lại danh sách sản phẩm
            </a>
        </div>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tên biến thể</th>
                    <th>Giá</th>
                    <th>Loại file(cập nhật để xem file)</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productVariants as $index => $variant)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $variant->name }}</td>
                        <td>{{ number_format($variant->price, 0, ',', '.') }} VND</td>
                        <td>
                            <div class="type-selection">
                                <input type="radio" name="type_{{ $variant->id }}" value="Email"
                                    class="update-type" data-id="{{ $variant->id }}"
                                    {{ $variant->type === 'Email' ? 'checked' : '' }}> Email
                                <input type="radio" name="type_{{ $variant->id }}" value="Tài khoản"
                                    class="update-type" data-id="{{ $variant->id }}"
                                    {{ $variant->type === 'Tài khoản' ? 'checked' : '' }}> Tài khoản
                            </div>
                        </td>
                        <td>
                            <span class="badge {{ $variant->status == 'active' ? 'badge-success' : 'badge-danger' }}">
                                {{ $variant->status == 'active' ? 'Hoạt động' : 'Không hoạt động' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('product-variant-manage.edit', $variant) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit"></i> Chỉnh sửa
                            </a>
                            <a href="{{ route('stock-manage.index', $variant->id) }}"
                                class="btn btn-warning btn-sm stock-link"
                                data-type="{{ $variant->type }}"
                                {{ is_null($variant->type) ? 'disabled' : '' }}>
                                <i class="fas fa-box"></i> Xem File
                            </a>
                            <form action="{{ route('product-variant-manage.destroy', $variant) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                    <i class="fas fa-trash"></i> Xóa
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="card-footer text-center">
        <a href="{{ route('product-manage.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại danh sách sản phẩm
        </a>
    </div>
</div>

<script>
    $(document).ready(function () {
        $(".update-type").change(function () {
            let variantId = $(this).data("id");
            let selectedType = $(this).val();

            $.ajax({
                url: "{{ route('product-variant-manage.updateType') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    variant_id: variantId,
                    type: selectedType
                },
                success: function (response) {
                    if (response.success) {
                        alert("Cập nhật thành công!");
                        $(`a.stock-link[data-id="${variantId}"]`).removeAttr("disabled");
                    } else {
                        alert("Đã xảy ra lỗi, vui lòng thử lại!");
                    }
                }
            });
        });

        $(".stock-link").each(function () {
            if ($(this).data("type") === "") {
                $(this).attr("disabled", "disabled");
            }
        });
    });
</script>
@endsection
