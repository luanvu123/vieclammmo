@extends('layout')

@section('content')
    <div class="post-container">
        <div class="row">
            <div class="col-md-8">
                <h1 class="fw-bold">{{ $post->name }}</h1>
                <p class="text-muted">Viết bởi: <span class="text-success">{{ $post->customer->name ?? 'Ẩn danh' }}</span> •
                    {{ $post->created_at->format('d-m-Y H:i') }}
                </p>

                @if ($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid my-3" alt="{{ $post->name }}">
                @endif

                <div class="content-post">
                    {!! $post->description !!}
                </div>


                <!-- Bình luận -->
                <div class="mt-5">
                    <h3>Bình luận ({{ $post->comments->count() }})</h3>

                    <!-- Hiển thị các bình luận -->
                    @foreach ($post->comments as $comment)
                                    <div class="comment mb-3">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $comment->customer->email == 'bgntmrqph24111516@vnetwork.io.vn'
                        ? asset('img/admin-icon.png')
                        : asset('img/user-icon.png') }}" class="rounded-circle me-2" width="40" height="40">


                                            <div>
                                                <strong>{{ $comment->customer->name }}
                                                    @if ($comment->customer->email == 'bgntmrqph24111516@vnetwork.io.vn')
                                                        <i class="fa fa-check-circle" style="color:red; font-size: 80%;"
                                                            title="Thuộc hệ thống"></i>
                                                    @endif
                                                </strong>

                                                <div class="text-muted small">
                                                    {{ $comment->created_at->diffForHumans() }}
                                                    @if ($comment->donate_amount > 0)
                                                        • Donate: {{ number_format($comment->donate_amount) }} VND
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <p class="mt-2">{{ $comment->content }}</p>
                                    </div>
                    @endforeach

                    <!-- Form bình luận -->
                    @if (Auth::guard('customer')->check())
                        <form action="{{ route('comments.store') }}" method="POST" class="mt-3">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">

                            <div class="form-group mb-3">
                                <textarea name="content" class="form-control" rows="3" placeholder="Nhập bình luận của bạn..."
                                    required></textarea>
                            </div>

                            <div class="form-group mb-3">
                                <label>Số tiền donate (VND)</label>
                                <select name="donate_amount" class="form-control">
                                    <option value="">-- Chọn số tiền --</option>
                                    <option value="5000">5,000 VND</option>
                                    <option value="10000">10,000 VND</option>
                                    <option value="20000">20,000 VND</option>
                                    <option value="50000">50,000 VND</option>
                                    <option value="100000">100,000 VND</option>
                                </select>
                                <small class="text-muted">
                                    Số dư hiện tại: {{ number_format(Auth::guard('customer')->user()->Balance) }} VND
                                </small>
                            </div>


                            <button type="submit" class="btn btn-primary">Gửi bình luận</button>
                        </form>
                    @else
                        <p>Vui lòng <a href="{{ route('login.customer') }}">đăng nhập</a> để bình luận</p>
                    @endif

                </div>
            </div>

            <!-- Sidebar bên phải -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">Bài viết liên quan</div>
                    <ul class="list-group list-group-flush">
                        @foreach ($relatedPosts as $related)
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
