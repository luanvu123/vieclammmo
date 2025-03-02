<!DOCTYPE html>
<html>

<head>
    <title>
        Trang Admin
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords"
        content="Glance Design Dashboard Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,
SmartPhone Compatible web template, free WebDesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
    <script type="application/x-javascript">
        addEventListener("load", function() {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <script src="{{ asset('backend_admin/js/jquery-1.11.1.min.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.lordicon.com/qjzruarw.js"></script>
    <!-- Fonts -->

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('backend_admin/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <!-- Custom CSS -->
    <link href="{{ asset('backend_admin/css/style.css') }}" rel="stylesheet" type="text/css" />
    {{-- button --}}
    <link href="{{ asset('backend_admin/css/fronend/metachose.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend_admin/css/fronend/categorychoose.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend_admin/css/fronend/plane.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend_admin/css/fronend/hotdeal.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend_admin/css/fronend/buttoncoupon.css') }}" rel="stylesheet" type="text/css" />
    <!-- font-awesome icons CSS -->
    <link href="{{ asset('backend_admin/css/font-awesome.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend_admin/css/SidebarNav.min.css') }}" media="all" rel="stylesheet" type="text/css" />


    <script src="{{ asset('backend_admin/js/modernizr.custom.js') }}"></script>


    <!--webfonts-->
    <link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext"
        rel="stylesheet" />
    <script src="https://kit.fontawesome.com/3e3afb65d3.js" crossorigin="anonymous"></script>
    <!-- Metis Menu -->
    <script src="{{ asset('backend_admin/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('backend_admin/js/custom.js') }}"></script>
    <link href="{{ asset('backend_admin/css/custom.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend_admin/css/owl.carousel.css') }}" rel="stylesheet" />
    <script src="{{ asset('backend_admin/js/owl.carousel.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('backend_admin/css/dropzone.min.css') }}">

    <script>
        $(document).ready(function() {
            $('#owl-demo').owlCarousel({
                items: 3,
                lazyLoad: true,
                autoPlay: true,
                pagination: true,
                nav: true,
            });
        });
    </script>

    <style>
        .image-card {
            position: relative;
        }

        .image-card .btn-danger {
            position: absolute;
            right: 20px;
            top: 20px;
        }

        .message-avatar img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
    <!-- //requried-jsfiles-for owl -->
</head>

<body class="cbp-spmenu-push">
    @if (Auth::check())
        <div class="main-content">
            <div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
                <!--left-fixed -navigation-->
                <aside class="sidebar-left">
                    <nav class="navbar navbar-inverse">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                data-target=".collapse" aria-expanded="false">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <h1>
                                <a class="navbar-brand" href="{{ url('/') }}"><span
                                        class="fa fa-area-chart"></span> HOME<span class="dashboard_text">TapHoaMMO</span></a>
                            </h1>
                        </div>
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="sidebar-menu">
                                <li class="header">MAIN ADMIN</li>
                                <li class="treeview">
                                    <a href="">
                                        <img src="{{ asset('backend_admin/images/3643769_building_home_house_main_menu_icon.svg') }}"
                                            alt="Google" width="20" height="20">
                                        <span> Trang chủ</span>
                                    </a>
                                </li>
                                @php
                                    $segment = Request::segment(1);
                                @endphp
                                <li
                                    class="treeview {{ Request::is('users*') || Request::is('subcategories*') || Request::is('categories*') ? 'active' : '' }}">
                                    <a href="#">
                                        <img src="{{ asset('backend_admin/images/9165478_unbox_package_icon.svg') }}"
                                            alt="Google" width="20" height="20">
                                        <span>Quản lý hệ thống</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li class="{{ Request::is('users*')  ? 'active' : '' }}">
                                            <a href="{{ route('users.index') }}">
                                                <img src="{{ asset('backend_admin/images/9989338_rating_evaluation_grade_ranking_rate_icon.svg') }}"
                                                    alt="Google" width="20" height="20"> Tài khoản quản trị
                                            </a>
                                        </li>
                                         <li class="{{ Request::is('subcategories*')  ? 'active' : '' }}">
                                            <a href="{{ route('subcategories.index') }}">
                                                <img src="{{ asset('backend_admin/images/1851819_advertising_agent_banner_property_rent_icon.svg') }}"
                                                    alt="Google" width="20" height="20">SubCategory
                                            </a>
                                        </li>
                                        <li class="{{ Request::is('categories*')  ? 'active' : '' }}">
                                            <a href="{{ route('categories.index') }}">
                                                <img src="{{ asset('backend_admin/images/category-svgrepo-com.svg') }}"
                                                    alt="Google" width="20" height="20">Thể loại
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                 <li class="treeview {{ Request::is('customer-manage*') ? 'active' : '' }}">
                                    <a href="{{ route('customer-manage.index') }}">
                                        <img src="{{ asset('backend_admin/images/candidate-for-elections-svgrepo-com.svg') }}"
                                            alt="Google" width="20" height="20">
                                        <span> Khách hàng</span>

                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.navbar-collapse -->
                    </nav>
                </aside>
            </div>
            <!--left-fixed -navigation-->
            <!-- header-starts -->
            <div class="sticky-header header-section">
                <div class="header-left">
                    <!--toggle button start-->
                    <button id="showLeftPush"><i class="fa fa-bars"></i></button>
                    <!--toggle button end-->
                    <div class="clearfix"></div>
                </div>
                <div class="header-right">
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <div class="profile_details">
                            <ul>
                                <li class="dropdown profile_details_drop">
                                    <a href="{{ route('users.edit', auth()->user()) }}" class="dropdown-toggle"
                                        data-toggle="dropdown" aria-expanded="false">
                                        <div class="profile_img">
                                            <span class="prfil-img">
                                                @if (Auth::user()->image)
                                                    <img style="width: 40px;height: 40px;border-radius: 50%;object-fit: cover;"src="{{ asset('storage/' . Auth::user()->image) }}"
                                                        alt="">
                                                @else
                                                    <img style="width: 40px;height: 40px;border-radius: 50%;object-fit: cover;"
                                                        src="http://www.gravatar.com/avatar/00000000000000000000000000000000?d=mm&amp;s=300"
                                                        alt="">
                                                @endif
                                            </span>
                                            <div class="user-name">
                                                <p> {{ Auth::user()->name }}</p>
                                            </div>
                                            <i class="fa fa-angle-down lnr"></i>
                                            <i class="fa fa-angle-up lnr"></i>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                    <ul class="dropdown-menu drp-mnu">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                <i class="fa fa-sign-out"></i> Đăng xuất
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none">
                                                @csrf
                                            </form>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('users.edit', auth()->user()) }}">
                                                <i class="fa fa-user-edit"></i> Hồ sơ
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    @endguest
                    <div class="clearfix"></div>
                </div>

                <div class="clearfix"></div>
            </div>
            <!-- //header-ends -->
            <!-- main content start-->
            <div id="page-wrapper">
                <div class="main-page">
                    <div class="col_3">
                        <div class="col-md-3 widget widget1">
                            <div class="r3_counter_box">
                                <i class="pull-left fa fa-dollar icon-rounded"></i>
                                <div class="stats">
                                    <h5><strong>9</strong></h5>
                                    <span>Chiến dịch đang mở</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 widget widget1">
                            <div class="r3_counter_box">
                                <i class="pull-left fa fa-laptop user1 icon-rounded"></i>
                                <div class="stats">
                                    <h5><strong>6</strong></h5>
                                    <span>Tông số việc làm</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 widget widget1">
                            <div class="r3_counter_box">
                                <i class="pull-left fa fa-money user2 icon-rounded"></i>
                                <div class="stats">
                                    <h5><strong>5</strong></h5>
                                    <span> Ứng viên </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 widget widget1">
                            <div class="r3_counter_box">
                                <i class="pull-left fa fa-pie-chart dollar1 icon-rounded"></i>
                                <div class="stats">
                                    <h5><strong>3</strong></h5>
                                    <span>Nhà tuyển
                                        dụng</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 widget">
                            <div class="r3_counter_box">
                                <i class="pull-left fa fa-users dollar2 icon-rounded"></i>
                                <div class="stats">
                                    <h5><strong>1</strong></h5>
                                    <span>Dịch vụ đang chạy</span>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <br>


                    <script src="{{ asset('backend_admin/js/dropzone.min.js') }}"></script>
                    <!-- for amcharts js -->

                    <script src="{{ asset('backend_admin/js/amcharts.js') }}"></script>
                    <script src="{{ asset('backend_admin/js/serial.js') }}"></script>
                    <script src="{{ asset('backend_admin/js/export.min.js') }}"></script>
                    <link rel="stylesheet" href="{{ asset('backend_admin/css/export.css') }}" type="text/css"
                        media="all" />
                    <script src="{{ asset('backend_admin/js/light.js') }}"></script>
                    <!-- for amcharts js -->
                    <script src="{{ asset('backend_admin/js/index1.js') }}"></script>
                    <script src="{{ asset('backend_admin/js/index.js') }}"></script>
                    <script src="{{ asset('backend_admin/js/index2.js') }}"></script>
                    <div class="col-md-12">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @yield('content')
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>

            <!--footer-->
            <div class="footer">
                <p>
                    &copy; 2018 Glance Design Dashboard. All Rights Reserved | Design by
                    <a href="#" target="_blank">w3layouts</a>
                </p>
            </div>
            <!--//footer-->
        </div>
    @else
        @yield('content_login')
    @endif

    <script src="{{ asset('backend_admin/js/classie.js') }}"></script>
    <script>
        var menuLeft = document.getElementById('cbp-spmenu-s1'),
            showLeftPush = document.getElementById('showLeftPush'),
            body = document.body;

        showLeftPush.onclick = function() {
            classie.toggle(this, 'active');
            classie.toggle(body, 'cbp-spmenu-push-toright');
            classie.toggle(menuLeft, 'cbp-spmenu-open');
            disableOther('showLeftPush');
        };

        function disableOther(button) {
            if (button !== 'showLeftPush') {
                classie.toggle(showLeftPush, 'disabled');
            }
        }
    </script>
    <script src="{{ asset('backend_admin/js/jquery.nicescroll.js') }}"></script>
    <script src="{{ asset('backend_admin/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('backend_admin/js/scripts.js') }}"></script>
    <!--//scrolling js-->
    <!-- side nav js -->
    <script src="{{ asset('backend_admin/js/SidebarNav.min.js') }}" type="text/javascript"></script>
    <script>
        $('.sidebar-menu').SidebarNav();
    </script>
    <script src="{{ asset('backend_admin/js/bootstrap.js') }}"></script>
    <!-- //Bootstrap Core JavaScript -->




    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">

    <!-- Include DataTables JavaScript -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#user-table').DataTable();
        });
    </script>

    <script>
        CKEDITOR.replace('summary2');
        CKEDITOR.replace('summary3');
        CKEDITOR.replace('summary1');
        CKEDITOR.replace('summary4');
        CKEDITOR.replace('summary5');
        CKEDITOR.replace('summary6');
    </script>

    <script src="{{ asset('backend_admin/js/utils.js') }}"></script>

    <link rel="stylesheet" href="https://cdn.bootcdn.net/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://cdn.bootcdn.net/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


    {{-- {!! Toastr::message() !!} --}}

</body>

</html>

