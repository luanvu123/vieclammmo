<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Taphoa MMO Login and Register </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="{{ asset('backend-template/assets/css/bootstrap.min.css') }}">
    <link type="text/css" rel="stylesheet"
        href="{{ asset('backend-template/assets/fonts/font-awesome/css/font-awesome.min.css') }}">
    <link type="text/css" rel="stylesheet"
        href="{{ asset('backend-template/assets/fonts/flaticon/font/flaticon.css') }}">

    <!-- Favicon icon -->
    <link rel="shortcut icon" href="{{ asset('backend-template/assets/img/favicon.ico') }}" type="image/x-icon">

    <!-- Google fonts -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800%7CPoppins:400,500,700,800,900%7CRoboto:100,300,400,400i,500,700">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600;700;800;900&amp;display=swap"
        rel="stylesheet">

    <!-- Custom Stylesheet -->
    <link type="text/css" rel="stylesheet" href="{{ asset('backend-template/assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" id="style_sheet"
        href="{{ asset('backend-template/assets/css/skins/default.css') }}">


</head>

<body id="top">
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
    @yield('content_login')
    <script src="{{ asset('backend-template/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('backend-template/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('backend-template/assets/js/bootstrap.bundle.min.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.bootcdn.net/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://cdn.bootcdn.net/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

</body>

</html>
