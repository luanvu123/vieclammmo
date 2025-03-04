@forelse($posts as $post)
<article>
    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->name }}">
    <h3>
        <a href="{{ route('post.detail', $post->slug) }}">{{ $post->name }}</a>
    </h3>
    <p>
        <strong>{{ $post->customer->name ?? 'Admin' }}</strong> -
        {{ $post->created_at->format('d-m-Y H:i') }}
    </p>
    <p>{!! Str::limit($post->description, 150) !!}</p>
    <div class="stats">
        <span>👁️ {{ $post->view }}</span>
        <span>👍 0</span>
        <span>💬 0</span>
    </div>
</article>
@empty
<p>Không có bài viết nào.</p>
@endforelse

