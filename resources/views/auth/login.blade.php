@extends('layouts.layout_login')

@section('content_login')
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TAGCODE" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div class="page_loader"></div>

    <!-- Login 21 start -->
    <div class="login-21">
        <div class="container-fluid">
            <div class="row login-box">
                <div class="col-lg-5 form-text">
                    <div class="info clearfix">
                        <h1 class="animate-charcter">Welcome To Admin TaphoaMMO</h1>

                    </div>
                </div>
                <div class="col-lg-7 align-self-center form-section">
                    <div class="form-inner">
                        <a href="{{ route('/') }}" class="logo">
                           <h1>TapHoa<span class="highlight">MMO</span></h1>
                        </a>
                        <h3>Sign Into Your Account</h3>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group form-box">
                                <input id="email" type="email" name="email" class="form-control"
                                    placeholder="Email Address" aria-label="Email Address">
                                <i class="flaticon-mail-2"></i>
                            </div>
                            <div class="form-group form-box">
                                <input id="password" type="password" name="password" class="form-control"
                                    autocomplete="off" placeholder="Password" aria-label="Password">
                                <i class="flaticon-password"></i>
                            </div>
                            <div class="checkbox form-group form-box">
                                <div class="form-check checkbox-theme">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                    <label class="form-check-label" for="remember">
                                        Remember me
                                    </label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="forgot-password">Forgot Password</a>
                                @endif
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn-md btn-theme w-100">Login</button>
                            </div>
                        </form>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
