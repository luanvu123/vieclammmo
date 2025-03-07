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
                    @foreach ($conversations as $conversation)
                        @php
                            $otherUser =
                                $conversation->sender_id == $customer->id
                                    ? $conversation->receiver
                                    : $conversation->sender;
                        @endphp
                        <div class="conversation-item @if (request('chat_to') == $otherUser->name) active @endif"
                            data-user-id="{{ $otherUser->id }}" data-user-name="{{ $otherUser->name }}">
                            <div class="avatar">
                                <img src="{{ asset('img/user-icon.png') }}" alt="User">
                            </div>
                            <div class="conversation-info">
                                <div class="conversation-header">
                                    <h4>{{ $otherUser->name }}</h4>
                                    <span class="date">{{ $conversation->created_at->format('d/m/Y') }}</span>
                                </div>
                                <p class="preview">{{ \Str::limit($conversation->message, 30) }}</p>
                            </div>
                            @if ($conversation->status == 'sent' && $conversation->receiver_id == $customer->id)
                                <div class="conversation-status">
                                    <span class="unread-badge">1</span>
                                </div>
                            @endif
                        </div>
                    @endforeach
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
                                <h3 id="chat-recipient-name">{{ request('chat_to') ?? 'Chọn người để nhắn tin' }}</h3>
                                <span class="status online">Online</span>
                            </div>
                        </div>
                        <div class="chat-actions">
                            <span class="warning-badge">Xin hãy cảnh giác với giao dịch không được bảo hiểm bên ngoài
                                sàn!</span>
                        </div>
                    </div>

                    <div class="chat-messages" id="chat-messages">
                        <!-- Tin nhắn sẽ được tải AJAX khi chọn người dùng -->
                    </div>

                    <div id="filePreview" class="file-preview"></div>

                    <div class="chat-input">
                        <form id="messageForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="receiver_id" name="receiver_id">
                            <div class="input-actions">
                                <button type="button" class="attachment-btn"><i class="fas fa-paperclip"></i></button>
                                <button type="button" class="emoji-btn"><i class="far fa-smile"></i></button>
                            </div>
                            <input type="file" id="fileInput" name="attachment"
                                accept="image/*, .pdf, .doc, .docx, .xlsx" style="display: none;">
                            <input type="text" id="messageInput" name="message" placeholder="Type a message">
                            <button type="button" class="send-btn"><i class="fas fa-paper-plane"></i></button>

                            <!-- Emoji Picker -->
                            <div class="emoji-picker">
                                <div class="emoji-list">
                                    <span>😀</span> <span>😃</span> <span>😄</span> <span>😁</span> <span>😆</span>
                                    <span>😅</span> <span>😂</span> <span>🤣</span> <span>😊</span> <span>😇</span>
                                    <span>🙂</span> <span>🙃</span> <span>😉</span> <span>😌</span> <span>😍</span>
                                    <span>🥰</span> <span>😘</span> <span>😗</span> <span>😙</span> <span>😚</span>
                                    <span>🤗</span> <span>🤩</span> <span>😏</span> <span>😞</span> <span>😟</span>
                                    <span>😠</span> <span>😡</span> <span>🤬</span> <span>🤯</span> <span>😳</span>
                                </div>
                            </div>
                        </form>
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
    <script>
        $(document).ready(function() {
            // Xử lý hiển thị emoji picker
            $('.emoji-btn').click(function() {
                $('.emoji-picker').toggle();
            });

            // Chọn emoji
            $('.emoji-list span').click(function() {
                const emoji = $(this).text();
                $('#messageInput').val($('#messageInput').val() + emoji);
                $('.emoji-picker').hide();
            });

            // Xử lý chọn file
            $('.attachment-btn').click(function() {
                $('#fileInput').click();
            });

            // Xử lý hiển thị preview khi chọn file
            $('#fileInput').change(function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    $('#filePreview').html('');

                    if (file.type.startsWith('image/')) {
                        reader.onload = function(e) {
                            $('#filePreview').html(`
                        <div class="preview-item">
                            <img src="${e.target.result}" alt="Preview">
                            <span class="file-name">${file.name}</span>
                            <button type="button" class="remove-file">&times;</button>
                        </div>
                    `);
                        }
                        reader.readAsDataURL(file);
                    } else {
                        $('#filePreview').html(`
                    <div class="preview-item">
                        <div class="file-icon"><i class="fas fa-file"></i></div>
                        <span class="file-name">${file.name}</span>
                        <button type="button" class="remove-file">&times;</button>
                    </div>
                `);
                    }
                }
            });

            // Xóa file được chọn
            $(document).on('click', '.remove-file', function() {
                $('#fileInput').val('');
                $('#filePreview').html('');
            });

            // Chọn người nhận tin nhắn
            $('.conversation-item').click(function() {
                const userId = $(this).data('user-id');
                const userName = $(this).data('user-name');

                $('.conversation-item').removeClass('active');
                $(this).addClass('active');

                $('#receiver_id').val(userId);
                $('#chat-recipient-name').text(userName);

                // Tải tin nhắn với người này
                loadMessages(userId);
            });

            // Tự động chọn người dùng từ query parameter
            const urlParams = new URLSearchParams(window.location.search);
            const chatTo = urlParams.get('chat_to');
            if (chatTo) {
                const userItem = $(`.conversation-item[data-user-name="${chatTo}"]`);
                if (userItem.length) {
                    userItem.click();
                }
            }

            // Gửi tin nhắn khi nhấn nút gửi
            $('.send-btn').click(function() {
                sendMessage();
            });

            // Gửi tin nhắn khi nhấn Enter
            $('#messageInput').keypress(function(e) {
                if (e.which === 13) { // Enter key
                    sendMessage();
                    return false;
                }
            });

            // Hàm gửi tin nhắn
            function sendMessage() {
                const receiverId = $('#receiver_id').val();
                const message = $('#messageInput').val().trim();

                if (!receiverId) {
                    alert('Vui lòng chọn người nhận');
                    return;
                }

                if (!message && !$('#fileInput')[0].files[0]) {
                    alert('Vui lòng nhập tin nhắn hoặc chọn file');
                    return;
                }

                const formData = new FormData($('#messageForm')[0]);

                $.ajax({
                    url: "{{ route('send.message') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            // Thêm tin nhắn vào khung chat
                            const messageHtml = `
                        <div class="message-row shop-message">
                            <div class="message-content">
                                <div class="message-info">
                                    <span class="time">${getCurrentTime()}</span>
                                </div>
                                <div class="message-bubble">
                                    <p>${response.message.message || ''}</p>
                                    ${response.message.attachment ? getAttachmentPreview(response.message.attachment) : ''}
                                </div>
                            </div>
                            <div class="avatar">
                                <img src="{{ asset('img/user-icon.png') }}" alt="${response.customer_name}">
                            </div>
                        </div>
                    `;

                            $('#chat-messages').append(messageHtml);

                            // Xóa nội dung input và file
                            $('#messageInput').val('');
                            $('#fileInput').val('');
                            $('#filePreview').html('');

                            // Scroll xuống cuối
                            scrollToBottom();
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert('Có lỗi xảy ra khi gửi tin nhắn');
                    }
                });
            }

            // Lấy định dạng thời gian hiện tại
            function getCurrentTime() {
                const now = new Date();
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const day = String(now.getDate()).padStart(2, '0');
                const month = String(now.getMonth() + 1).padStart(2, '0');

                return `${hours}:${minutes} - ${day}/${month}`;
            }

            // Lấy HTML cho file đính kèm
            function getAttachmentPreview(attachment) {
                const ext = attachment.split('.').pop().toLowerCase();
                const isImage = ['jpg', 'jpeg', 'png', 'gif'].includes(ext);

                if (isImage) {
                    return `<div class="attachment-preview">
                <img src="{{ asset('storage') }}/${attachment}" alt="Attachment">
            </div>`;
                } else {
                    return `<div class="attachment-file">
                <a href="{{ asset('storage') }}/${attachment}" target="_blank">
                    <i class="fas fa-file"></i> Xem tập tin đính kèm
                </a>
            </div>`;
                }
            }

            // Tải tin nhắn với một người dùng
            function loadMessages(userId) {
                // API route cần được tạo
                $.ajax({
                    url: `/load-messages/${userId}`,
                    type: "GET",
                    success: function(response) {
                        $('#chat-messages').html(response);
                        scrollToBottom();
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        $('#chat-messages').html('<p class="text-center">Không thể tải tin nhắn</p>');
                    }
                });
            }

            // Cuộn xuống cuối khung chat
            function scrollToBottom() {
                const chatMessages = document.getElementById('chat-messages');
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        });
    </script>
@endsection
