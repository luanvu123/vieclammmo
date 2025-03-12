@extends('layouts.app')

@section('title', 'Edit Info')

@section('content')
<div class="container-fluid">
    <div class="card card-primary mt-4">
        <div class="card-header">
            <h3 class="card-title">Sửa giao diện</h3>
        </div>

        <form action="{{ route('infos.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $info->email) }}">
                </div>

                <div class="form-group">
                    <label>Clock</label>
                    <input type="text" name="clock" class="form-control" value="{{ old('clock', $info->clock) }}">
                </div>

                <div class="form-group">
                    <label>Footer</label>
                    <textarea name="footer" class="form-control">{{ old('footer', $info->footer) }}</textarea>
                </div>

                <div class="form-group">
                    <label>RSS</label>
                    <input type="text" name="rss" class="form-control" value="{{ old('rss', $info->rss) }}">
                </div>

                <div class="form-group">
                    <label>YouTube</label>
                    <input type="text" name="youtube" class="form-control" value="{{ old('youtube', $info->youtube) }}">
                </div>

                <div class="form-group">
                    <label>Facebook</label>
                    <input type="text" name="facebook" class="form-control" value="{{ old('facebook', $info->facebook) }}">
                </div>

                <div class="form-group">
                    <label>STK</label>
                    <input type="text" name="stk" class="form-control" value="{{ old('stk', $info->stk) }}">
                </div>

                <div class="form-group">
                    <label>Logo Bank</label>
                    <input type="file" name="logo_bank" class="form-control">
                    @if ($info->logo_bank)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $info->logo_bank) }}" alt="Logo Bank" width="100">
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label>Account Name</label>
                    <input type="text" name="account_name" class="form-control" value="{{ old('account_name', $info->account_name) }}">
                </div>

                <div class="form-group">
                    <label>Account Content</label>
                    <textarea name="account_content" class="form-control">{{ old('account_content', $info->account_content) }}</textarea>
                </div>

                <div class="form-group">
                    <label>QR Code</label>
                    <input type="file" name="qr_code" class="form-control">
                    @if ($info->qr_code)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $info->qr_code) }}" alt="QR Code" width="100">
                        </div>
                    @endif
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection
