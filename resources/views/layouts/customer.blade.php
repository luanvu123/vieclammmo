<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="dark" data-bs-theme="light">

<head>


    <meta charset="utf-8" />
    <title>Trang bán hàng</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">


        <link href="{{ asset('assets/libs/uppy/uppy.min.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('assets/libs/simple-datatables/style.css')}}" rel="stylesheet" type="text/css" />
    <!-- App css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/libs/quill/quill.snow.css') }}">

</head>

<body>

    <!-- Top Bar Start -->
    <div class="topbar d-print-none">
        <div class="container-fluid">
            <nav class="topbar-custom d-flex justify-content-between" id="topbar-custom">


                <ul class="topbar-item list-unstyled d-inline-flex align-items-center mb-0">
                    <li>
                        <button class="nav-link mobile-menu-btn nav-icon" id="togglemenu">
                            <i class="iconoir-menu"></i>
                        </button>
                    </li>
                    <li class="hide-phone app-search">
                        <form role="search" action="#" method="get">
                            <input type="search" name="search" class="form-control top-search mb-0"
                                placeholder="Search here...">
                            <button type="submit"><i class="iconoir-search"></i></button>
                        </form>
                    </li>
                </ul>
                <ul class="topbar-item list-unstyled d-inline-flex align-items-center mb-0">

                    <li class="dropdown">
                        <a class="nav-link dropdown-toggle arrow-none nav-icon" data-bs-toggle="dropdown" href="#"
                            role="button" aria-haspopup="false" aria-expanded="false" data-bs-offset="0,19">
                            <img src="{{ asset('assets/images/flags/us_flag.jpg') }}" alt=""
                                class="thumb-sm rounded-circle">
                        </a>
                    </li><!--end topbar-language-->

                    <li class="topbar-item">
                        <a class="nav-link nav-icon" href="javascript:void(0);" id="light-dark-mode">
                            <i class="iconoir-half-moon dark-mode"></i>
                            <i class="iconoir-sun-light light-mode"></i>
                        </a>
                    </li>



                    <li class="dropdown topbar-item">
                        <a class="nav-link dropdown-toggle arrow-none nav-icon" data-bs-toggle="dropdown"
                            href="#" role="button" aria-haspopup="false" aria-expanded="false"
                            data-bs-offset="0,19">
                            <img src="{{ asset('img/user-icon.png') }}" alt=""
                                class="thumb-md rounded-circle">
                        </a>
                        <div class="dropdown-menu dropdown-menu-end py-0">
                            <div class="d-flex align-items-center dropdown-item py-2 bg-secondary-subtle">
                                <div class="flex-shrink-0">
                                    <img src="{{ asset('img/user-icon.png') }}" alt=""
                                        class="thumb-md rounded-circle">
                                </div>
                                <div class="flex-grow-1 ms-2 text-truncate align-self-center">
                                    <h6 class="my-0 fw-medium text-dark fs-13">
                                        {{ Auth::guard('customer')->user()->name }}</h6>
                                    <small class="text-muted mb-0">
                                        {{ Auth::guard('customer')->user()->email }}</small>
                                </div><!--end media-body-->
                            </div>
                            <div class="dropdown-divider mt-0"></div>
                            <small class="text-muted px-2 pb-1 d-block">Account</small>
                            <a class="dropdown-item" href="{{ route('profile.site') }}"><i
                                    class="las la-user fs-18 me-1 align-text-bottom"></i> Profile</a>
                            <small class="text-muted px-2 py-1 d-block">Settings</small>
                            <a class="dropdown-item" href="{{ route('profile.edit.site') }}"><i
                                    class="las la-cog fs-18 me-1 align-text-bottom"></i>Account Settings</a>

                            <a class="dropdown-item" href="{{route('faqs')}}"><i
                                    class="las la-question-circle fs-18 me-1 align-text-bottom"></i> Help Center</a>
                            <div class="dropdown-divider mb-0"></div>
                            <a class="dropdown-item text-danger" href="{{route('/')}}"><i
                                    class="las la-power-off fs-18 me-1 align-text-bottom"></i> Logout</a>
                        </div>
                    </li>
                </ul><!--end topbar-nav-->
            </nav>
            <!-- end navbar-->
        </div>
    </div>
    <!-- Top Bar End -->
    <!-- leftbar-tab-menu -->
    <div class="startbar d-print-none">
        <!--start brand-->
        <div class="brand">
            <a href="{{ route('dashboard.site') }}" class="logo">
                <span>
                    <img src="{{ asset('assets/images/logo-sm.png') }}" alt="logo-small" class="logo-sm">
                </span>
                <span class="">
                   <a href="{{ route('/') }}" class="logo">
                <h1>MNL<span class="highlight">MMO</span></h1>
            </a>
                </span>
            </a>
        </div>
        <!--end brand-->
        <!--start startbar-menu-->
        <div class="startbar-menu">
            <div class="startbar-collapse" id="startbarCollapse" data-simplebar>
                <div class="d-flex align-items-start flex-column w-100">
                    <!-- Navigation -->
                    <ul class="navbar-nav mb-auto w-100">
                        <li class="menu-label mt-2">
                            <span>Main</span>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard.site') }}">
                                <i class="iconoir-report-columns menu-icon"></i>
                                <span>Sales</span>
                                <span class="badge text-bg-info ms-auto">New</span>
                            </a>
                        </li><!--end nav-item-->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('products.index') }}">
                                <i class="iconoir-hand-cash menu-icon"></i>
                                <span>Quản lý gian hàng</span>
                            </a>
                        </li><!--end nav-item-->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('coupons.index') }}">
                                <i class="iconoir-hand-cash menu-icon"></i>
                                <span>Quản lý mã giảm</span>
                            </a>
                        </li><!--end nav-item-->
                         <li class="nav-item">
                            <a class="nav-link" href="{{ route('order-manage.index') }}">
                                <i class="iconoir-hand-cash menu-icon"></i>
                                <span>Gian hàng sản phẩm</span>
                            </a>
                        </li><!--end nav-item-->
                          <li class="nav-item">
                            <a class="nav-link" href="{{ route('order-service-manage.index') }}">
                                <i class="iconoir-hand-cash menu-icon"></i>
                                <span>Gian hàng dịch vụ</span>
                            </a>
                        </li><!--end nav-item-->
                          <li class="nav-item">
                            <a class="nav-link" href="{{ route('complaints.index') }}">
                                <i class="iconoir-report-columns menu-icon"></i>
                                <span>Quản lý khiếu nại</span>
                                <span class="badge text-bg-info ms-auto">New</span>
                            </a>
                        </li><!--end nav-item-->
                          <li class="nav-item">
                            <a class="nav-link" href="{{ route('review-manage.index') }}">
                                <i class="iconoir-report-columns menu-icon"></i>
                                <span>Quản lý đánh giá</span>
                                <span class="badge text-bg-info ms-auto">New</span>
                            </a>
                        </li><!--end nav-item-->
                        <li class="nav-item">
                            <a class="nav-link" href="#sidebarTransactions" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebarTransactions">
                                <i class="iconoir-task-list menu-icon"></i>
                                <span>Transactions</span>
                            </a>
                            <div class="collapse " id="sidebarTransactions">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="transactions.html">Overview</a>
                                    </li><!--end nav-item-->
                                    <li class="nav-item">
                                        <a class="nav-link" href="new-transaction.html">Add Transactions</a>
                                    </li><!--end nav-item-->
                                </ul><!--end nav-->
                            </div><!--end startbarTables-->
                        </li><!--end nav-item-->
                        <li class="nav-item">
                            <a class="nav-link" href="cards.html">
                                <i class="iconoir-credit-cards menu-icon"></i>
                                <span>Cards</span>
                                <span class="badge text-bg-pink ms-auto">03</span>
                            </a>
                        </li><!--end nav-item-->
                    </ul><!--end navbar-nav--->
                </div>
            </div><!--end startbar-collapse-->
        </div><!--end startbar-menu-->
    </div><!--end startbar-->
    <div class="startbar-overlay d-print-none"></div>
    <!-- end leftbar-tab-menu-->

    <div class="page-wrapper">


        @yield('content')
        <!-- end page content -->
    </div>


    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>

    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('apexcharts.com/samples/assets/stock-prices.js') }}"></script>
    <script src="{{ asset('assets/js/pages/index.init.js') }}"></script>
    <script src="{{ asset('assets/js/DynamicSelect.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
     <script src="{{ asset('assets/libs/uppy/uppy.legacy.min.js')}}"></script>
        <script src="{{ asset('assets/js/pages/file-upload.init.js')}}"></script>


    <script src="{{ asset('assets/libs/quill/quill.js') }}"></script>
    <script src="{{ asset('assets/libs/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/js/pages/datatable.init.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#datatable_1').DataTable();
    });
</script>
 <script src="{{ asset('backend_admin/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('description');

    </script>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        function toggleFields() {
            let type = document.getElementById("couponType").value;
            let percentField = document.getElementById("percentField");
            let maxAmountField = document.getElementById("maxAmountField");

            if (type === "percent") {
                percentField.style.display = "block";
                maxAmountField.style.display = "none";
            } else {
                percentField.style.display = "none";
                maxAmountField.style.display = "block";
            }
        }

        document.getElementById("couponType").addEventListener("change", toggleFields);

        // Chạy lần đầu để thiết lập trạng thái ban đầu
        toggleFields();
    });
</script>
</body>

</html>
