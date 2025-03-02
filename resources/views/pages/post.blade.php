@extends('layout')

@section('content')


<div class="post-container">
    <h1>Kinh nghiệm Marketing</h1>
    <p>Nơi chia sẻ kiến thức, kinh nghiệm, và trải nghiệm về kiếm tiền online.</p>

    <div class="content">
        <aside class="sidebar">
            <input type="text" placeholder="Tìm bài viết..." class="search-bar">
            <button class="btn">Quản lý bài viết</button>
            <h2>Thể loại</h2>
            <ul>
                <li>Nội dung khác - (53)</li>
                <li>Facebook - (48)</li>
                <li>Tiktok - (41)</li>
                <li>Telegram - (13)</li>
                <li>Marketing - (12)</li>
                <li>TapHoaMMO - (5)</li>
                <li>Youtube - (3)</li>
                <li>Airdrop - (3)</li>
                <li>Blockchain - (1)</li>
                <li>Zalo - (1)</li>
            </ul>
        </aside>

        <main class="articles">
            <article>
                <img src="{{ asset('img/map.png') }}" alt="Google Maps">
                <h3>Hướng Dẫn Tạo Google Maps Bán Hàng Phủ Số Lượng Lớn</h3>
                <p><strong>tuanvu681995</strong> - 24-12-2024 23:03</p>
                <p>Google Maps là một trong những công cụ quan trọng giúp các doanh nghiệp tiếp cận khách hàng...</p>
                <div class="stats">
                    <span>👁️ 961</span>
                    <span>👍 0</span>
                    <span>💬 0</span>
                </div>
            </article>
            <article>
                <img src="{{ asset('img/int.png') }}" alt="Instagram">
                <h3>CÁCH MỞ CÔNG KHAI THEO DÕI INSTAGRAM</h3>
                <p><strong>hodangvinh</strong> - 05-11-2024 17:28</p>
                <p>Bước 1: Vào phần cá nhân > chọn cài đặt. Bước 2: Cuộn xuống...</p>
                <div class="stats">
                    <span>👁️ 58</span>
                    <span>👍 0</span>
                    <span>💬 0</span>
                </div>
            </article>
        </main>
    </div>
</div>
@endsection

