@extends('layouts.customer')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                        <h4 class="page-title">{{ $variant->name }}</h4>
                        <div class="">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">TaphoaMMO</a>
                                </li><!--end nav-item-->
                                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">{{ $variant->product->name }}</a>
                                </li><!--end nav-item-->
                                <li class="breadcrumb-item active">{{ $variant->name }}</li>
                            </ol>
                        </div>
                    </div><!--end page-title-box-->
                </div><!--end col-->
            </div><!--end row-->
            <div class="row justify-content-center">

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div class="col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                                Tải lên File cho biến thể sản phẩm: <span class="text-primary">{{ $variant->name }}</span>
                            </h4>
                        </div>


                        <div class="card-body">
                            <form action="{{ route('stocks.store', $variant->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="file" class="form-label">Chọn file tải lên:</label>
                                    <input type="file" name="file" id="file"
                                        class="form-control @error('file') is-invalid @enderror" required>
                                    @error('file')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">Tải lên</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h4 class="card-title"> Chú ý: File tải lên mỗi dòng sẽ là 1 sản phẩm.</h4>
                                </div><!--end col-->
                            </div> <!--end row-->
                        </div><!--end card-header-->
                        <div class="card-body pt-0">
                            <div class="d-grid">


                                <p class="text-muted"> Cấu trúc dòng:
                                    Email: username@gmail.com|password|..... </p>
                                <p class="text-muted">Phần mềm: xxx.... </p>
                                <p class="text-muted">
                                    Tài khoản: username|password and(or) anything else </p>
                                <p class="text-muted"> Loại khác: xxx.... </p>
                                </p>
                            </div>
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div> <!--end col-->
            </div><!--end row-->
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h4 class="card-title">Export Table</h4>
                                </div><!--end col-->
                            </div> <!--end row-->
                        </div><!--end card-header-->
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table class="table datatable" id="datatable_2">
                                    <thead class="">

                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>

                            </div>
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div> <!--end col-->
            </div><!--end row-->



        </div><!-- container -->

    </div>
@endsection
