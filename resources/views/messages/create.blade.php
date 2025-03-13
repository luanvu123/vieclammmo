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
                    @foreach ($conversations as $id => $messages)
                        @php
                            $user =
                                $messages->first()->sender_id == Auth::guard('customer')->id()
                                    ? $messages->first()->receiver
                                    : $messages->first()->sender;
                            $lastMessage = $messages->last();
                            $unreadCount = $messages
                                ->where('receiver_id', Auth::guard('customer')->id())
                                ->where('is_read', false)
                                ->count();
                        @endphp

                        @if ($user->id != Auth::guard('customer')->id())
                            <a href="{{ route('messages.create', $user->id) }}" class="conversation-link">
                                <div class="conversation-item {{ $receiver->id == $user->id ? 'active' : '' }}">
                                    <div class="avatar">
                                        <img src="{{ $user->email == 'bgntmrqph24111516@vnetwork.io.vn'
                                            ? asset('img/admin-icon.png')
                                            : asset('img/user-icon.png') }}"
                                            alt="{{ $user->name }}">
                                    </div>

                                    <div class="conversation-info">
                                        <div class="conversation-header">
                                            <h4>{{ $user->name }} @if ($user->email == 'bgntmrqph24111516@vnetwork.io.vn')
                                                    <i class="fa fa-check-circle" style="color:red; font-size: 80%;"
                                                        title="Thuộc hệ thống"></i>
                                                @endif
                                            </h4>
                                            <span class="date">{{ $lastMessage->created_at->format('d/m/Y') }}</span>
                                        </div>
                                        <p class="preview">{{ Str::limit($lastMessage->message, 30) }}</p>
                                    </div>
                                    @if ($unreadCount > 0)
                                        <div class="conversation-status">
                                            <span class="unread-badge">{{ $unreadCount }}</span>
                                        </div>
                                    @endif
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>


            </div>

            <div class="message-main">
                <div class="chat-container">
                    @if ($receiver->id != Auth::guard('customer')->id())
                        <div class="chat-header">
                            <div class="chat-user-info">
                                <div class="avatar">
                                    <img src="{{ $receiver->email === 'bgntmrqph24111516@vnetwork.io.vn' ? asset('img/admin-icon.png') : asset('img/user-icon.png') }}"
                                        alt="User">
                                </div>

                                <div class="user-details">
                                    <a
                                        href="{{ route('profile.name.site', $receiver->name ?? '') }}">{{ $receiver->name ?? 'Unknown' }}</a>
                                    @if ($receiver->email == 'bgntmrqph24111516@vnetwork.io.vn')
                                        <i class="fa fa-check-circle" style="color:red; font-size: 80%;"
                                            title="Thuộc hệ thống"></i>
                                    @endif
                                    </br>
                                    <span class="status online">Online {{ $lastActiveTime ?? 'hiện tại' }}</span>
                                </div>
                            </div>
                            <div class="chat-actions">
                                <span class="warning-badge">Xin hãy cảnh giác với giao dịch không được bảo hiểm bên ngoài
                                    sàn!</span>
                            </div>
                        </div>

                        <div class="chat-messages">
                            @foreach (\App\Models\Message::where(function ($query) use ($receiver) {
            $query->where('sender_id', Auth::guard('customer')->id())->where('receiver_id', $receiver->id);
        })->orWhere(function ($query) use ($receiver) {
                $query->where('sender_id', $receiver->id)->where('receiver_id', Auth::guard('customer')->id());
            })->orderBy('created_at')->get() as $message)
                                <div
                                    class="message-row {{ $message->sender_id == Auth::guard('customer')->id() ? 'user-message' : 'shop-message' }}">
                                    <div class="avatar">
                                        <img src="{{ $message->sender->email === 'bgntmrqph24111516@vnetwork.io.vn' ? asset('img/admin-icon.png') : asset('img/user-icon.png') }}"
                                            alt="{{ $message->sender_id == Auth::guard('customer')->id() ? 'User' : 'Shop' }}">
                                    </div>

                                    <div class="message-content">
                                        <div class="message-bubble">
                                            <p>{{ $message->message }}</p>
                                            @if ($message->attachment)
                                                <p><a href="{{ asset('storage/' . $message->attachment) }}"
                                                        target="_blank">Xem
                                                        tệp đính kèm</a></p>
                                            @endif
                                        </div>
                                        <div class="message-info">
                                            <span class="time">{{ $message->created_at->format('H:i - d/m') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div id="filePreview"></div>

                        <form action="{{ route('messages.store', $receiver->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="chat-input">
                                <div class="input-actions">
                                    <button type="button" class="attachment-btn"><i class="fas fa-paperclip"></i></button>
                                    <button type="button" class="emoji-btn"><i class="far fa-smile"></i></button>
                                </div>
                                <input type="file" id="fileInput" name="attachment"
                                    accept="image/*, .pdf, .doc, .docx, .xlsx" style="display: none;">
                                <input type="text" id="messageInput" name="message" placeholder="Type a message"
                                    required>
                                <button type="submit" class="send-btn"><i class="fas fa-paper-plane"></i></button>
                            </div>

                            <div class="emoji-picker" style="display: none;">
                                <div class="emoji-list">
                                    <span>😀</span> <span>😃</span> <span>😄</span> <span>😁</span> <span>😆</span>
                                    <span>😅</span>
                                    <span>😂</span> <span>🤣</span> <span>😊</span> <span>😇</span> <span>🙂</span>
                                    <span>🙃</span>
                                    <span>😉</span> <span>😍</span> <span>🥰</span> <span>😘</span> <span>😗</span>
                                    <span>😙</span>
                                    <span>🤩</span> <span>🤗</span> <span>😏</span> <span>😞</span> <span>😠</span>
                                    <span>😡</span>
                                </div>
                            </div>
                        </form>
                    @else
                        <p class="text-center text-danger">Xem danh sách tin nhắn.</p>
                    @endif


                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const emojiBtn = document.querySelector(".emoji-btn");
            const emojiPicker = document.querySelector(".emoji-picker");
            const emojiList = document.querySelectorAll(".emoji-list span");
            const messageInput = document.querySelector("#messageInput");

            // Toggle emoji picker khi nhấn vào nút emoji
            emojiBtn.addEventListener("click", function(event) {
                event.preventDefault();
                emojiPicker.style.display = emojiPicker.style.display === "block" ? "none" : "block";
            });

            // Chọn emoji và chèn vào input
            emojiList.forEach(emoji => {
                emoji.addEventListener("click", function() {
                    messageInput.value += emoji.innerText;
                    emojiPicker.style.display = "none"; // Ẩn sau khi chọn
                    messageInput.focus();
                });
            });

            // Ẩn emoji picker nếu nhấn ra ngoài
            document.addEventListener("click", function(event) {
                if (!emojiPicker.contains(event.target) && !emojiBtn.contains(event.target)) {
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
