@extends('layout')
@section('content')
    <div class="post-container">
        <h1>Kinh nghiệm Marketing</h1>
        <p>Nơi chia sẻ kiến thức, kinh nghiệm, và trải nghiệm về kiếm tiền online.</p>
        <div class="content">
            <aside class="sidebar">
                <div class="search-container">
                    <input type="text" id="search-input" placeholder="Tìm bài viết..." class="search-bar">
                    <button id="search-btn" class="submit-btn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </button>
                </div>

                <button class="btn-ql">Quản lý bài viết</button>

                <h2>Thể loại</h2>
                <ul id="genre-list">
                    <li>
                        <a href="#" data-genre="" class="genre-item active">
                            Tất cả bài viết
                        </a>
                    </li>
                    @foreach ($genres as $genre)
                        <li>
                            <a href="#" data-genre="{{ $genre->id }}" class="genre-item">
                                {{ $genre->name }} - ({{ $genre->posts()->where('status', 1)->count() }})
                            </a>
                        </li>
                    @endforeach
                </ul>
            </aside>

            <main id="articles-container" class="articles">
                @include('pages.post-list', ['posts' => $posts])
            </main>

            <div id="pagination-container">
                {{ $posts->appends(request()->input())->links('vendor.pagination.default') }}
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let searchInput = document.getElementById('search-input');
            let searchBtn = document.getElementById('search-btn');
            let articlesContainer = document.getElementById('articles-container');
            let paginationContainer = document.getElementById('pagination-container');
            let genreItems = document.querySelectorAll('.genre-item');
            let currentGenre = '';

            // Xử lý tìm kiếm
            function performSearch() {
                let searchTerm = searchInput.value;
                fetchPosts(searchTerm, currentGenre);
            }

            searchBtn.addEventListener('click', performSearch);
            searchInput.addEventListener('keyup', function(event) {
                if (event.key === 'Enter') {
                    performSearch();
                }
            });

            // Xử lý chọn thể loại
            genreItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Xóa active ở các item khác
                    genreItems.forEach(i => i.classList.remove('active'));

                    // Thêm active cho item được chọn
                    this.classList.add('active');

                    // Lấy genre
                    currentGenre = this.getAttribute('data-genre');

                    // Tìm kiếm với genre đã chọn
                    fetchPosts(searchInput.value, currentGenre);
                });
            });

            // Hàm fetch posts
            function fetchPosts(search = '', genre = '') {
                let url = '{{ route('post.site') }}';
                let params = new URLSearchParams();

                if (search) params.append('search', search);
                if (genre) params.append('genre', genre);

                fetch(`${url}?${params.toString()}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        articlesContainer.innerHTML = data.html;
                        paginationContainer.innerHTML = data.links;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        });
    </script>
@endsection
