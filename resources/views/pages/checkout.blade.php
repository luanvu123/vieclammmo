@extends('layout')
@section('content')
    <div class="post-container">


        <h2>
            <img src="{{ $layout_info->logo_bank ? asset('storage/' . $layout_info->logo_bank) : asset('img/seabank.png') }}"
                alt="SeABank" width="50"> SeABank
        </h2>
        <div class="bank-info">
            <p><strong>STK:</strong> {{ $layout_info->stk ?? 'Chưa có số tài khoản' }}</p>
            <p><strong>Người nhận:</strong> <b>{{ $layout_info->account_name ?? 'Chưa có tên người nhận' }}</b></p>
            <p><strong>Nội dung chuyển khoản:</strong>
                <span id="transferCode">TS {{ Auth::guard('customer')->user()->idCustomer ?? 'Chưa xác định' }}</span>
                <button class="copy-btn" onclick="copyText()">Copy</button>
            </p>
        </div>

        <div class="qr-code">
            <img src="{{ $layout_info->qr_code ? asset('storage/' . $layout_info->qr_code) : asset('img/generateQRCode.png') }}"
                alt="QR Code" width="150">
        </div>
        <div class="notes">
            <p><b>Lưu ý:</b></p>
            <ul>
                <li>Điền chính xác nội dung chuyển khoản để thực hiện nạp tiền tự động.</li>
                <li>Không chấp nhận giao dịch nạp tiền từ tài khoản công ty.</li>
                <li>Tiền sẽ vào tài khoản trong vòng 1-10 phút sau khi giao dịch thành công.</li>
                <li><b>Vietcombank không kiểm tra lịch sử giao dịch từ 23h - 3h</b>.</li>
            </ul>
        </div>
        <script>
            function copyText() {
                var text = document.getElementById("transferCode").innerText;
                navigator.clipboard.writeText(text).then(() => {
                    alert("Đã sao chép nội dung chuyển khoản: " + text);
                }).catch(err => {
                    console.error("Lỗi khi sao chép:", err);
                });
            }
        </script>
    </div>
@endsection
