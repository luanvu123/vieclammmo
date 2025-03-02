@extends('layout')

@section('content')
    <div class="post-container">
        <div class="row">
            <!-- Nội dung bài viết -->
            <div class="col-md-8">
                <h1 class="fw-bold">Cách Bắt Đầu Kênh YouTube Giấu Mặt Kiếm Tiền Mỗi Tháng</h1>
                <p class="text-muted">Viết bởi: <span class="text-success">nhanmmo97</span> • 10-01-2025 15:03</p>
                <div class="content-post">
                    <p>Chào các bạn! Nếu bạn đang có ý định kiếm tiền trực tuyến, tôi cho rằng một trong những cách tốt nhất
                        để làm điều đó là thông qua các kênh YouTube không cần mặt.</p>
                    <h3>Tại Sao YouTube Là Cơ Hội Vàng?</h3>
                    <p>Có rất nhiều lý do mà YouTube trở thành một "mỏ vàng"...</p>
                    <h3>Giữ Bí Mật Danh Tính</h3>
                    <p>Một lợi thế lớn của YouTube là bạn hoàn toàn có thể làm video mà không cần lộ mặt...</p>
                </div>

                <!-- Bình luận -->
                <div class="mt-5">
                    <h3>Bình luận (3)</h3>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <strong>Nguyễn Văn A</strong> - 2 giờ trước
                            <p>Bài viết rất hữu ích, cảm ơn tác giả!</p>
                        </li>
                        <li class="list-group-item">
                            <strong>Trần Thị B</strong> - 5 giờ trước
                            <p>Tôi đã thử và thấy rất hiệu quả.</p>
                        </li>
                        <li class="list-group-item">
                            <strong>Lê Văn C</strong> - 1 ngày trước
                            <p>Rất mong có thêm nhiều bài viết như thế này!</p>
                        </li>
                    </ul>

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
                <!-- Thể loại -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">Thể loại</div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="#">Facebook</a>
                            <span class="badge bg-secondary">48</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="#">Tiktok</a>
                            <span class="badge bg-secondary">41</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="#">Youtube</a>
                            <span class="badge bg-secondary">3</span>
                        </li>
                    </ul>
                </div>

                <!-- Bài viết mới -->
                <div class="card-post">
                    <div class="card-header bg-success text-white">Bài viết mới</div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex align-items-center">
                            <img src="{{ asset('img/map.png') }}" alt="Bài viết 1" class="me-2 rounded">
                            <div>
                                <a href="#">Tại sao các nhà đầu tư nhỏ lẻ thường thua lỗ trên thị trường?</a>
                                <p class="text-muted small">hunght1890 • 11-02-2025 15:59</p>
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <img src="{{ asset('img/int.png') }}" alt="Bài viết 2" class="me-2 rounded">
                            <div>
                                <a href="#">SHARE TUT VƯỢT MƠ</a>
                                <p class="text-muted small">admin • 09-02-2025 14:30</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
