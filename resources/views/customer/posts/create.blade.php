@extends('layout')

@section('content')
    <div class="post-container">
        <h1>Kinh nghiệm Marketing</h1>
        <p>Nơi chia sẻ kiến thức, kinh nghiệm, và trải nghiệm về kiếm tiền online.</p>

        <div class="content">
            <main class="articles">
                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Tiêu đề</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" placeholder="Nhập tiêu đề bài viết">
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="genre_post_id">Thể loại</label>
                            <select name="genre_post_id" class="form-control @error('genre_post_id') is-invalid @enderror">
                                <option value="">Chọn thể loại</option>
                                @foreach ($genres as $genre)
                                    <option value="{{ $genre->id }}"
                                        {{ old('genre_post_id') == $genre->id ? 'selected' : '' }}>
                                        {{ $genre->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('genre_post_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Nội dung</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="5" placeholder="Nhập nội dung bài viết">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="image">Ảnh bài viết</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('image') is-invalid @enderror"
                                        id="image" name="image" accept="image/*">
                                    <label class="custom-file-label" for="image">Chọn ảnh</label>
                                </div>
                            </div>
                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Tạo bài viết</button>
                        <a href="{{ route('/') }}" class="btn btn-secondary">Quay lại</a>
                    </div>
                </form>
            </main>
            <main class="articles">
                <div class="card-body table-responsive p-0">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <table class="table table-hover text-nowrap" id="user-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tiêu đề</th>
                                <th>Thể loại</th>

                                <th>Lượt xem</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $post)
                                <tr>
                                    <td>{{ $post->id }}</td>
                                    <td>{{ $post->name }}</td>
                                    <td>{{ $post->genrePost->name }}</td>
                                    <td>{{ $post->view }}</td>
                                    <td>

                                        {{ $post->status == 1 ? 'Hoạt động' : 'Đang duyệt' }}

                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <!-- Nút Chỉnh sửa -->
                                            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <!-- Nút Xóa -->
                                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                                                style="display:inline-block;"
                                                onsubmit="return confirm('Bạn có chắc muốn xóa?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>

                                            <!-- Nút Xem chi tiết -->
                                            <a href="{{ route('post.detail', $post->slug) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i> Xem
                                            </a>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
    <script>
        // Custom file input label
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>
@endsection
