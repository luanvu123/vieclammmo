@foreach($messages as $message)
    @if($message->sender_id == $customer->id)
        <!-- Tin nhắn từ customer (người dùng hiện tại) -->
        <div class="message-row shop-message">
            <div class="message-content">
                <div class="message-info">
                    <span class="time">{{ $message->created_at->format('H:i - d/m') }}</span>
                </div>
                <div class="message-bubble">
                    <p>{{ $message->message }}</p>
                    @if($message->attachment)
                        @php
                            $ext = pathinfo($message->attachment, PATHINFO_EXTENSION);
                            $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif']);
                        @endphp

                        @if($isImage)
                            <div class="attachment-preview">
                                <img src="{{ asset('storage/' . $message->attachment) }}" alt="Attachment">
                            </div>
                        @else
                            <div class="attachment-file">
                                <a href="{{ asset('storage/' . $message->attachment) }}" target="_blank">
                                    <i class="fas fa-file"></i> Xem tập tin đính kèm
                                </a>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
            <div class="avatar">
                <img src="{{ asset('img/user-icon.png') }}" alt="{{ $customer->name }}">
            </div>
        </div>
    @else
        <!-- Tin nhắn từ người khác -->
        <div class="message-row user-message">
            <div class="avatar">
                <img src="{{ asset('img/user-icon.png') }}" alt="User">
            </div>
            <div class="message-content">
                <div class="message-bubble">
                    <p>{{ $message->message }}</p>
                    @if($message->attachment)
                        @php
                            $ext = pathinfo($message->attachment, PATHINFO_EXTENSION);
                            $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif']);
                        @endphp

                        @if($isImage)
                            <div class="attachment-preview">
                                <img src="{{ asset('storage/' . $message->attachment) }}" alt="Attachment">
                            </div>
                        @else
                            <div class="attachment-file">
                                <a href="{{ asset('storage/' . $message->attachment) }}" target="_blank">
                                    <i class="fas fa-file"></i> Xem tập tin đính kèm
                                </a>
                            </div>
                        @endif
                    @endif
                </div>
                <div class="message-info">
                    <span class="time">{{ $message->created_at->format('H:i - d/m') }}</span>
                </div>
            </div>
        </div>
    @endif
@endforeach
