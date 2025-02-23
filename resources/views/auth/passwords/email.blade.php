@extends('layouts.layout_login')

@section('content_login')
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TAGCODE" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div class="page_loader"></div>

    <!-- Login 21 start -->
    <div class="login-21">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="container-fluid">
            <div class="row login-box">
                <div class="col-lg-5 form-text">
                    <div class="info clearfix">
                        <h1 class="animate-charcter">Welcome To Admin TapHoaMMo</h1>
                    </div>
                </div>
                <div class="col-lg-7 form-section">
                    <div class="form-inner">
                        <a href="{{ route('/') }}" class="logo">
                            <h1>TapHoa<span class="highlight">MMO</span></h1>
                        </a>
                        <h3>Recover Your Password</h3>
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="form-group form-box">
                                <input type="email" id="email" name="email" class="form-control"
                                    placeholder="Email Address" aria-label="Email Address">

                                <i class="flaticon-mail-2"></i>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn-md btn-theme w-100">Send Me Email</button>
                            </div>
                            <div class="clearfix"></div>
                        </form>
                        <div class="clearfix"></div>
                        <p>Already a member? <a href="{{ route('home') }}">Login here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
