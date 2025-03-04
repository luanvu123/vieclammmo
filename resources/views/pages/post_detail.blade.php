@extends('layout')

@section('content')
    <div class="post-container">
        <div class="row">
            <div class="col-md-8">
                <h1 class="fw-bold">{{ $post->name }}</h1>
                <p class="text-muted">Viết bởi: <span class="text-success">{{ $post->customer->name ?? 'Ẩn danh' }}</span> • {{ $post->created_at->format('d-m-Y H:i') }}</p>

                @if($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid my-3" alt="{{ $post->name }}">
                @endif

                <div class="content-post">
                    {!! $post->description !!}
                </div>

                <!-- Bình luận (nếu có tích hợp) -->
                <div class="mt-5">
                    <h3>Bình luận (0)</h3>
                    <form action="#" method="POST" class="mt-3">
                        <div class="form-group">
                            <textarea name="content" class="form-control" rows="3" placeholder="Nhập bình luận của bạn..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Gửi bình luận</button>
                    </form>
                </div>
            </div>

            <!-- Sidebar bên phải -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">Bài viết liên quan</div>
                    <ul class="list-group list-group-flush">
                        @foreach($relatedPosts as $related)
                            <li class="list-group-item">
                                <a href="{{ route('post.detail', $related->slug) }}">{{ $related->name }}</a>
                                <p class="text-muted small">{{ $related->created_at->format('d-m-Y') }}</p>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

