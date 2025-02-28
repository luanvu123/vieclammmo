@extends('layout')

@section('content')
    <div class="container">
        <h2>Xác thực 2FA</h2>
        <form action="{{ route('2fa.verify.post') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="verification_code">Mã xác thực:</label>
                <input type="text" name="verification_code" id="verification_code" class="form-control" required>
                @error('verification_code')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Xác thực</button>
        </form>
    </div>
@endsection

