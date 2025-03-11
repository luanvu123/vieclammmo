@extends('layout')

@section('content')
<div class="post-container">
    <h1>Danh sách yêu cầu rút tiền</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($withdrawals->isEmpty())
        <div class="alert alert-info">Không có yêu cầu rút tiền nào.</div>
    @else
        <table class="table table-bordered" id="user-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ngân hàng</th>
                    <th>Tên tài khoản</th>
                    <th>Số tài khoản</th>
                    <th>Số tiền</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($withdrawals as $withdrawal)
                    <tr>
                        <td>{{ $withdrawal->id }}</td>
                        <td>{{ $withdrawal->bank }}</td>
                        <td>{{ $withdrawal->bankAccName }}</td>
                        <td>{{ $withdrawal->bankAccNum }}</td>
                        <td>{{ number_format($withdrawal->amount, 0, ',', '.') }} VND</td>
                        <td>
                            @if ($withdrawal->status == 'đang chờ')
                                <span class="text-yellow-custom">Đang chờ</span>
                            @elseif ($withdrawal->status == 'thành công')
                                <span class="text-green-custom">Thành công</span>
                            @elseif ($withdrawal->status == 'thất bại')
                                <span class="text-red-custom">Thất bại</span>
                            @endif
                        </td>
                        <td>{{ $withdrawal->created_at->format('d-m-Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
