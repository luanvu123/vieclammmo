@extends('layout')
@section('content')
    <div class="post-container">
        <h2>Đăng Ký Bán Hàng</h2>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Cơ hội hợp tác</h4>
                    </div>
                    <div class="card-body">
                        <ul>
                            <li>
                                <strong>Thông tin này hoàn toàn được bảo mật</strong>, được dùng để bên mình liên lạc với bên bạn trong những lúc cần thiết (xác thực người bán, khi có tranh chấp xảy ra...).
                            </li>
                            <li>
                                Cùng nhau kết nối, hợp tác, cùng phát triển cộng đồng kiếm tiền online.
                            </li>
                            <li>
                                <strong>Tối ưu hóa</strong><br>
                                Đội ngũ hỗ trợ sẽ liên lạc để giúp bạn tối ưu khả năng bán hàng.
                            </li>
                            <li>
                                <strong>Đẩy tin nhắn</strong><br>
                                Hãy vào phần thông tin tài khoản (profile), cập nhật thêm phần đẩy tin nhắn của khách về Telegram để không bỏ lỡ khách nào nhé.
                            </li>
                            <li>
                                <strong>Bật bảo mật 2 lớp (2FA)</strong><br>
                                Đây là quy định bắt buộc trước khi đăng ký bán hàng, vui lòng cập nhật thêm trong profile.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Thông tin cửa hàng</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('customer.registerSeller') }}" method="POST">
                            @csrf

                            <div class="form-group mb-3">
                                <label for="phone">Số điện thoại</label>
                                <input type="text" name="phone" class="form-control" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="account_number">Tên tài khoản ngân hàng</label>
                                <input type="text" name="account_number" class="form-control" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="url_facebook">Facebook</label>
                                <input type="text" name="url_facebook" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-success">Đăng ký</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
