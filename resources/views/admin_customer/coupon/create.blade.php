@extends('layouts.customer')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                        <h4 class="page-title">Quản lý mã giảm giá</h4>
                        <div class="">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="#">TaphoaMMO</a></li>
                                <li class="breadcrumb-item"><a href="#">Quản lý mã giảm giá</a></li>
                                <li class="breadcrumb-item active">Thêm mã giảm giá</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Thêm mã giảm giá</h4>
                        </div>
                        <div class="card-body pt-0">
                            <form action="{{ route('coupons.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Mã giảm giá</label>
                                            <input type="text" name="coupon_key" class="form-control" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Chọn sản phẩm</label>
                                            <select name="product_id" class="form-select" required>
                                                <option value="">Chọn sản phẩm</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                @endforeach
                                            </select>

                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Ngày bắt đầu</label>
                                            <input type="date" name="start_date" class="form-control" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Ngày kết thúc</label>
                                            <input type="date" name="end_date" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Loại</label>
                                            <select name="type" class="form-select" required id="couponType">
                                                <option value="percent">Phần trăm</option>
                                                <option value="fixed">Giảm giá cố định</option>
                                            </select>
                                        </div>

                                        <div class="mb-3" id="percentField">
                                            <label class="form-label">Giảm giá (%)</label>
                                            <input type="number" name="percent" class="form-control" min="0" max="100">
                                        </div>

                                        <div class="mb-3" id="maxAmountField">
                                            <label class="form-label">Giá trị giảm tối đa</label>
                                            <input type="number" name="max_amount" class="form-control">
                                        </div>




                                        <div class="mb-3">
                                            <label class="form-label">Mô tả</label>
                                            <textarea name="description" class="form-control" rows="3"></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Trạng thái</label>
                                            <select name="status" class="form-select" required>
                                                <option value="active">Hoạt động</option>
                                                <option value="inactive">Không hoạt động</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-primary">Thêm mã giảm giá</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
