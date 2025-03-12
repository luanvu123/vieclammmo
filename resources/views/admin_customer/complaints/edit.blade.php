@extends('layouts.customer')
@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4>Chỉnh sửa khiếu nại</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('complaints.update', $complaint->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="content" class="form-label">Nội dung khiếu nại:</label>
                        <textarea name="content" id="content" class="form-control" rows="4" disabled>{{ $complaint->content }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Trạng thái:</label>
                        <select name="status" id="status" class="form-control">
                            <option value="pending" {{ $complaint->status == 'pending' ? 'selected' : '' }}>Đang chờ xử lý</option>
                            <option value="resolved" {{ $complaint->status == 'resolved' ? 'selected' : '' }}>Đã xử lý</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a href="{{ route('complaints.index') }}" class="btn btn-secondary">Quay lại</a>
                </form>
            </div>
        </div>
    </div>
@endsection
