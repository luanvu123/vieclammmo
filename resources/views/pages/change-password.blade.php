@extends('layout')
@section('content')
    <div class="post-container">
        <h2>Thay Đổi Mật Khẩu</h2>

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

        <form action="{{ route('customer.updatePassword') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label for="current_password">Mật Khẩu Hiện Tại</label>
                <input type="password" name="current_password" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="new_password">Mật Khẩu Mới</label>
                <input type="password" name="new_password" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="new_password_confirmation">Xác Nhận Mật Khẩu Mới</label>
                <input type="password" name="new_password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Cập Nhật Mật Khẩu</button>
        </form>
    </div>
@endsection
