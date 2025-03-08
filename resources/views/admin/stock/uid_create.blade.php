@extends('layouts.app')

@section('title', 'Thêm UID Facebook')

@section('content_header')
    <h1>Thêm UID cho Stock ID: {{ $stock->id }}</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('stock.uid_store', $stock->id) }}" method="POST" id="uidForm">
            @csrf
            <div class="form-group">
                <label for="type">Chọn loại dữ liệu</label>
                <select name="type" id="type" class="form-control">
                    <option value="facebook">Nhập nhiều UID Facebook</option>
                    <option value="email">Nhập nhiều UID Email</option>
                </select>
            </div>

            <div class="form-group">
                <label for="uids">Nhập nhiều UID hoặc Email (mỗi dòng một giá trị)</label>
                <textarea name="uids" class="form-control @error('uids') is-invalid @enderror" rows="5" required></textarea>
                @error('uids')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Lưu dữ liệu
            </button>
        </form>
    </div>

    <div class="card-footer">
        <a href="{{ route('stock.uid_index', $stock->id) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại danh sách
        </a>
    </div>
</div>

<script>
    document.getElementById('uidForm').addEventListener('submit', function(event) {
        const type = document.getElementById('type').value;
        if (type === 'email') {
            this.action = "{{ route('stock.uid_email_store', $stock->id) }}";
        } else {
            this.action = "{{ route('stock.uid_store', $stock->id) }}";
        }
    });
</script>


@stop
