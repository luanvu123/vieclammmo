@extends('layout')
@section('content')
    <div class="post-container">
        <h1>Chỉnh sửa đánh giá</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('reviews.update', $review->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="rating">Đánh giá (Số sao):</label>
                <select name="rating" id="rating" class="form-control">
                    @for($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" {{ $review->rating == $i ? 'selected' : '' }}>
                            {{ $i }} sao
                        </option>
                    @endfor
                </select>
            </div>

            <div class="form-group mt-3">
                <label for="content">Nội dung đánh giá:</label>
                <textarea name="content" id="content" rows="5" class="form-control">{{ old('content', $review->content) }}</textarea>
            </div>

            <div class="form-group mt-3">
                <label for="quality_status">Trạng thái chất lượng:</label><br>
                <div>
                    <label><input type="checkbox" name="quality_status[]" value="Đúng mô tả" {{ in_array('Đúng mô tả', explode(',', $review->quality_status)) ? 'checked' : '' }}> Đúng mô tả</label>
                </div>
                <div>
                    <label><input type="checkbox" name="quality_status[]" value="Chất lượng tốt" {{ in_array('Chất lượng tốt', explode(',', $review->quality_status)) ? 'checked' : '' }}> Chất lượng tốt</label>
                </div>
                <div>
                    <label><input type="checkbox" name="quality_status[]" value="Đóng gói cẩn thận" {{ in_array('Đóng gói cẩn thận', explode(',', $review->quality_status)) ? 'checked' : '' }}> Đóng gói cẩn thận</label>
                </div>
            </div>

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary">Cập nhật đánh giá</button>
                <a href="{{ route('reviews.index') }}" class="btn btn-secondary">Quay lại</a>
            </div>
        </form>
    </div>
@endsection
