@extends('layout')

@section('content')
    <div class="post-container">
        <div class="message-header">
            <h2>Tin nhắn</h2>
            <p>Quản lý tin nhắn và hỗ trợ của bạn</p>
        </div>

        <div class="message-content">
            <div class="message-sidebar">
                <div class="message-search">
                    <input type="text" placeholder="Tìm kiếm tin nhắn...">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </div>
                <div class="conversation-list">
                    <!-- Danh sách các cuộc trò chuyện -->
                    <div class="conversation-item active">
                        <div class="avatar">
                            <img src="{{ asset('img/user-icon.png') }}" alt="User">
                        </div>
                        <div class="conversation-info">
                            <div class="conversation-header">
                                <h4>chuyensitemailus</h4>
                                <span class="date">10/11/2024</span>
                            </div>
                            <p class="preview">Đơn hàng khiếu nại: TNMYHSM8WD đã...</p>
                        </div>
                        <div class="conversation-status">
                            <span class="unread-badge">1</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="message-main">
                <div class="chat-container">
                    <div class="chat-header">
                        <div class="chat-user-info">
                            <div class="avatar">
                                <img src="{{ asset('img/user-icon.png') }}" alt="User">
                            </div>
                            <div class="user-details">
                                <h3>samir_43ah9q</h3>
                                <span class="status online">Online 59 ngày trước</span>
                            </div>
                        </div>
                        <div class="chat-actions">
                            <span class="warning-badge">Xin hãy cảnh giác với giao dịch không được bảo hiểm bên ngoài
                                sàn!</span>
                        </div>
                    </div>

                    <div class="chat-messages">
                        <!-- Tin nhắn từ người dùng -->
                        <div class="message-row user-message">
                            <div class="avatar">
                                <img src="{{ asset('img/user-icon.png') }}" alt="User">
                            </div>
                            <div class="message-content">
                                <div class="message-bubble">
                                    <p>nó xoá mail rồi shop ơi</p>
                                </div>
                                <div class="message-info">
                                    <span class="time">16:10 - 06/11</span>
                                </div>
                            </div>
                        </div>

                        <!-- Tin nhắn từ shop -->
                        <div class="message-row shop-message">
                            <div class="message-content">
                                <div class="message-info">
                                    <span class="time">16:10 - 06/11</span>
                                </div>
                                <div class="message-bubble">
                                    <p>Nó xóa mail luôn rồi</p>
                                </div>

                            </div>
                            <div class="avatar">
                                <img src="{{ asset('img/user-icon.png') }}" alt="Shop">
                            </div>

                        </div>

                        <!-- Tin nhắn từ người dùng -->
                        <div class="message-row user-message">
                            <div class="avatar">
                                <img src="{{ asset('img/user-icon.png') }}" alt="User">
                            </div>
                            <div class="message-content">
                                <div class="message-bubble">
                                    <p>Đổi bằng cách nào ?</p>
                                </div>
                                <div class="message-info">
                                    <span class="time">16:10 - 06/11</span>
                                </div>
                            </div>
                        </div>
                        <!-- Tin nhắn từ shop -->
                        <div class="message-row shop-message">
                            <div class="message-content">
                                <div class="message-info">
                                    <span class="time">18:19 - 06/11</span>
                                </div>
                                <div class="message-bubble alert-message">
                                    <p>QUÊN MẬT KHẨU</p>
                                </div>

                            </div>
                            <div class="avatar">
                                <img src="{{ asset('img/user-icon.png') }}" alt="Shop">
                            </div>

                        </div>
                    </div>
                    <div id="filePreview"></div>
                    <div class="chat-input">
                        <div class="input-actions">
                            <button class="attachment-btn"><i class="fas fa-paperclip"></i></button>
                            <button class="emoji-btn"><i class="far fa-smile"></i></button>
                        </div>
                        <input type="file" id="fileInput" accept="image/*, .pdf, .doc, .docx, .xlsx"
                            style="display: none;">

                        <!-- Hiển thị file đã chọn -->

                        <input type="text" id="messageInput" placeholder="Type a message">
                        <button class="send-btn"><i class="fas fa-paper-plane"></i></button>
                        <!-- Input file ẩn -->

                        <!-- Emoji Picker -->
                        <!-- Emoji Picker -->
                        <div class="emoji-picker">
                            <div class="emoji-list">
                                <span>😀</span> <span>😃</span> <span>😄</span> <span>😁</span> <span>😆</span>
                                <span>😅</span>
                                <span>😂</span> <span>🤣</span> <span>😊</span> <span>😇</span> <span>🙂</span>
                                <span>🙃</span>
                                <span>😉</span> <span>😌</span> <span>😍</span> <span>🥰</span> <span>😘</span>
                                <span>😗</span>
                                <span>😙</span> <span>😚</span> <span>🤗</span> <span>🤩</span> <span>😏</span>
                                <span>😞</span>
                                <span>😟</span> <span>😠</span> <span>😡</span> <span>🤬</span> <span>🤯</span>
                                <span>😳</span>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const emojiBtn = document.querySelector(".emoji-btn");
            const emojiPicker = document.querySelector(".emoji-picker");
            const messageInput = document.getElementById("messageInput");

            // Khi nhấn vào nút emoji, hiển thị hoặc ẩn danh sách emoji
            emojiBtn.addEventListener("click", function(event) {
                event.stopPropagation(); // Ngăn chặn sự kiện lan ra ngoài
                emojiPicker.style.display = emojiPicker.style.display === "block" ? "none" : "block";
            });

            // Khi chọn emoji, thêm vào messageInput
            document.querySelectorAll(".emoji-list span").forEach(emoji => {
                emoji.addEventListener("click", function() {
                    messageInput.value += emoji.textContent; // Thêm emoji vào ô nhập
                    messageInput.focus(); // Giữ focus trên ô nhập
                    emojiPicker.style.display = "none"; // Ẩn danh sách emoji sau khi chọn
                });
            });

            // Ẩn danh sách emoji khi click ra ngoài
            document.addEventListener("click", function(event) {
                if (!emojiBtn.contains(event.target) && !emojiPicker.contains(event.target)) {
                    emojiPicker.style.display = "none";
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const attachmentBtn = document.querySelector(".attachment-btn");
            const fileInput = document.getElementById("fileInput");
            const filePreview = document.getElementById("filePreview");

            // Khi nhấn nút attachment, mở file chọn
            attachmentBtn.addEventListener("click", function() {
                fileInput.click();
            });

            // Khi chọn file, hiển thị file đã tải lên
            fileInput.addEventListener("change", function() {
                filePreview.innerHTML = ""; // Xóa file trước đó (nếu có)
                const file = fileInput.files[0];

                if (file) {
                    const fileName = document.createElement("div");
                    fileName.classList.add("file-name");

                    if (file.type.startsWith("image/")) {
                        // Nếu là ảnh, hiển thị ảnh
                        const img = document.createElement("img");
                        img.src = URL.createObjectURL(file);
                        filePreview.appendChild(img);
                    } else {
                        // Nếu là file khác, hiển thị tên file
                        fileName.innerHTML =
                            `<i class="fas fa-file"></i> ${file.name} <i class="fas fa-times remove-file"></i>`;
                        filePreview.appendChild(fileName);
                    }

                    // Xóa file khi nhấn vào dấu X
                    fileName.querySelector(".remove-file")?.addEventListener("click", function() {
                        fileInput.value = ""; // Xóa file đã chọn
                        filePreview.innerHTML = "";
                    });
                }
            });
        });
    </script>
@endsection
