@extends('layouts.app')

@section('title', 'Thêm UID Facebook')

@section('content_header')
    <h1>Thêm UID cho Stock ID: {{ $stock->id }}</h1>
@stop

@section('content')
  <div class="card">
    <div class="card-body">
        <form action="{{ route('stock.uid_store', $stock->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="uids">Nhập nhiều UID (mỗi UID trên một dòng)</label>
                <textarea name="uids" class="form-control @error('uids') is-invalid @enderror" rows="5" required></textarea>
                @error('uids')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Lưu UID
            </button>
        </form>
    </div>
    <div class="card-footer">
        <a href="{{ route('stock.uid_index', $stock->id) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại danh sách UID
        </a>
    </div>
</div>

@stop
