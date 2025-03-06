@extends('layouts.app')

@section('title', 'Chỉnh sửa hỗ trợ')

@section('content_header')
    <h1>Chỉnh sửa hỗ trợ</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('supports.update', $support->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Email:</label>
                    <input type="text" class="form-control" value="{{ $support->email }}" disabled>
                </div>

                <div class="form-group">
                    <label>Số điện thoại:</label>
                    <input type="text" class="form-control" value="{{ $support->phone }}" disabled>
                </div>

                <div class="form-group">
                    <label>Chủ đề:</label>
                    <input type="text" class="form-control" value="{{ $support->subject }}" disabled>
                </div>

                <div class="form-group">
                    <label>Nội dung:</label>
                    <textarea class="form-control" rows="4" disabled>{{ $support->message }}</textarea>
                </div>

                <div class="form-group">
                    <label>Trạng thái:</label>
                    <select name="status" class="form-control">
                        <option value="Chưa phản hồi" {{ $support->status == 'Chưa phản hồi' ? 'selected' : '' }}>Chưa phản hồi</option>
                        <option value="Đã phản hồi" {{ $support->status == 'Đã phản hồi' ? 'selected' : '' }}>Đã phản hồi</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="{{ route('supports.index') }}" class="btn btn-secondary">Quay lại</a>
            </form>
        </div>
    </div>
@stop
