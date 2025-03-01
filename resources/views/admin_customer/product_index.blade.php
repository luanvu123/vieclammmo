@extends('layouts.customer')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                        <h4 class="page-title">Taxes</h4>
                        <div class="">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="#">Approx</a>
                                </li><!--end nav-item-->
                                <li class="breadcrumb-item active">Taxes</li>
                            </ol>
                        </div>
                    </div><!--end page-title-box-->
                </div><!--end col-->
            </div><!--end row-->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h4 class="card-title">Taxes Details</h4>
                                </div><!--end col-->
                                <div class="col-auto">
                                    <button class="btn bg-primary text-white"><i class="fas fa-plus me-1"></i> Add
                                        Rate</button>
                                </div><!--end col-->
                            </div><!--end row-->
                        </div><!--end card-header-->
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table class="table mb-0" id="datatable_1">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Category</th>
                                            <th>Subcategory</th>
                                            <th>Name</th>
                                            <th>Image</th>
                                            <th>Cashback (%)</th>
                                            <th>Status</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                            <tr>
                                                <td>{{ $product->id }}</td>
                                                <td>{{ $product->category->name }}</td>
                                                <td>{{ $product->subcategory->name }}</td>
                                                <td>{{ $product->name }}</td>
                                                <td>
                                                    <img src="{{ asset('storage/' . $product->image) }}" width="50"
                                                        alt="Product Image">
                                                </td>
                                                <td>{{ $product->cashback_percentage }}%</td>
                                                <td>
                                                    <span
                                                        class="badge bg-{{ $product->status == 'active' ? 'success' : 'danger' }}">
                                                        {{ ucfirst($product->status) }}
                                                    </span>
                                                </td>
                                                <td class="text-end">
                                                    <a href="{{ route('products.edit', $product->id) }}"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="las la-pen"></i>
                                                    </a>
                                                    <form action="{{ route('products.destroy', $product->id) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Are you sure?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="las la-trash-alt"></i>
                                                        </button>
                                                    </form>

                                                    <!-- Button mở modal -->
                                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                        data-bs-target="#addVariant{{ $product->id }}">
                                                        <i class="fas fa-plus"></i>
                                                    </button>

                                                    <!-- Modal -->
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="addVariant{{ $product->id }}"
                                                        tabindex="-1" aria-labelledby="addVariantLabel{{ $product->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="addVariantLabel{{ $product->id }}">
                                                                        Gian hàng {{ $product->name }}
                                                                    </h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <form action="{{ route('product_variants.store') }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <div class="modal-body">
                                                                        <input type="hidden" name="product_id"
                                                                            value="{{ $product->id }}">

                                                                        <!-- Name -->
                                                                        <div class="mb-2">
                                                                            <label>Tên mặt hàng</label>
                                                                            <input type="text" class="form-control"
                                                                                name="name" required>
                                                                        </div>

                                                                        <!-- Price -->
                                                                        <div class="mb-2">
                                                                            <label>Giá</label>
                                                                            <input type="number" class="form-control"
                                                                                name="price" step="0.01" required>
                                                                        </div>

                                                                        <!-- Chỉ hiển thị nếu là "Phần Mềm" -->
                                                                        @if ($product->category->name == 'Phần Mềm')
                                                                            <div class="mb-2">
                                                                                <label>Đơn vị tính hạn sử dụng</label>
                                                                                <input type="date" class="form-control"
                                                                                    name="expiry">
                                                                            </div>

                                                                            <div class="mb-2">
                                                                                <label>Đường dẫn tải phần mềm</label>
                                                                                <input type="text" class="form-control"
                                                                                    name="url">
                                                                            </div>
                                                                        @endif
                                                                        <button type="submit"
                                                                            class="btn btn-primary w-100">Thêm</button>
                                                                    </div>
                                                                </form>
                                                              <!-- Add this to your Blade template to replace the static display -->
<div class="modal-footer">
    <h6 class="text-center w-100">Danh sách mặt hàng</h6>
    <ul class="list-group w-100">
        @foreach ($product->productVariants as $variant)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div class="editable-container">
                    <form id="edit-form-{{ $variant->id }}" style="display: none;"
                          action="{{ route('product_variants.update', $variant->id) }}"
                          method="POST" class="d-inline edit-variant-form">
                        @csrf
                        @method('PUT')
                        <input type="text" name="name" value="{{ $variant->name }}" class="form-control form-control-sm d-inline" style="width: auto;">
                        <input type="number" name="price" value="{{ $variant->price }}" step="0.01" class="form-control form-control-sm d-inline" style="width: auto;">
                        <input type="hidden" name="expiry" value="{{ $variant->expiry }}">
                        <input type="hidden" name="url" value="{{ $variant->url }}">
                        <button type="submit" class="btn btn-sm btn-success"><i class="las la-check"></i></button>
                    </form>
                </div>
                <form action="{{ route('product_variants.destroy', $variant->id) }}"
                      method="POST" class="d-inline"
                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger"><i class="las la-trash-alt"></i></button>
                </form>
            </li>
        @endforeach
    </ul>
</div>
<script>
    function makeEditable(element, variantId) {
        // Hide the display text
        element.style.display = 'none';

        // Show the edit form
        document.getElementById('edit-form-' + variantId).style.display = 'inline-block';
    }



    // Optional: Add AJAX submission to avoid page reload
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('.edit-variant-form');
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                fetch(this.action, {
                    method: 'POST',
                    body: new FormData(this),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Get the variant ID from the form ID
                        const variantId = this.id.split('-')[2];

                        // Update the display text with new values
                        const nameInput = this.querySelector('input[name="name"]');
                        const priceInput = this.querySelector('input[name="price"]');
                        

                        // Format the price with 2 decimal places and VNĐ
                        const formattedPrice = new Intl.NumberFormat('vi-VN', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }).format(priceInput.value);

                        displayElement.textContent = `${nameInput.value} - ${formattedPrice} VNĐ`;

                        // Hide the form and show the updated text
                        cancelEdit(variantId);

                        // Show success message
                        alert('Cập nhật thành công!');
                    } else {
                        alert('Đã xảy ra lỗi khi cập nhật!');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Đã xảy ra lỗi khi cập nhật!');
                });
            });
        });
    });
</script>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div><!-- container -->
    </div>
@endsection
