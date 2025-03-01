@extends('layouts.customer')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                        <h4 class="page-title">Quản lý gian hàng</h4>
                        <div class="">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="#">TaphoaMMO</a>
                                </li><!--end nav-item-->
                                <li class="breadcrumb-item"><a href="#">Quản lý gian hàng</a>
                                </li><!--end nav-item-->
                                <li class="breadcrumb-item active">Thêm gian hàng</li>
                            </ol>
                        </div>
                    </div><!--end page-title-box-->
                </div><!--end col-->
            </div><!--end row-->
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h4 class="card-title">Thêm gian hàng</h4>
                                </div><!--end col-->
                            </div> <!--end row-->
                        </div><!--end card-header-->
                        <div class="card-body pt-0">
                            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Tên gian hàng</label>
                                            <input type="text" name="name" class="form-control" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Danh mục</label>
                                            <select name="category_id" class="form-select" id="categorySelect" required>
                                                <option value="">Chọn danh mục</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Danh mục con</label>
                                            <select name="subcategory_id" class="form-select" id="subcategorySelect"
                                                required>
                                                <option value="">Chọn danh mục con</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Mô tả ngắn</label>
                                            <input type="text" name="short_description" class="form-control">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Đánh giá hoàn tiền (%)</label>
                                            <input type="number" name="cashback_percentage" class="form-control"
                                                step="0.01" min="0" max="100">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Hình ảnh</label>
                                            <input type="file" name="image" class="form-control" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Mô tả chi tiết</label>
                                            <textarea name="description" class="form-control" rows="5"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
                                    </div>
                                </div>
                            </form>
                            <script>
                                document.getElementById('categorySelect').addEventListener('change', function() {
                                    let categoryId = this.value;
                                    let subcategorySelect = document.getElementById('subcategorySelect');
                                    subcategorySelect.innerHTML = '<option value="">Chọn danh mục con</option>';

                                    if (categoryId) {
                                        fetch(`/get-subcategories/${categoryId}`)
                                            .then(response => response.json())
                                            .then(data => {
                                                data.forEach(sub => {
                                                    let option = new Option(sub.name, sub.id);
                                                    subcategorySelect.add(option);
                                                });
                                            });
                                    }
                                });
                            </script>
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div> <!--end col-->
            </div><!--end row-->


        </div><!-- container -->
        <!--Start Rightbar-->
        <!--Start Rightbar/offcanvas-->

    </div>
@endsection
