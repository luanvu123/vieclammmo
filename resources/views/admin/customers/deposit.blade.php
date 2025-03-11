@extends('layouts.app')

@section('title', 'Lịch sử giao dịch')

@section('content')
    <div class="container">
        <h2>Lịch sử giao dịch của {{ $customer->name }}</h2>
        <table class="table table-bordered" id="user-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Số tiền</th>
                    <th>Loại giao dịch</th>
                    <th>Nội dung</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($deposits as $deposit)
                    <tr>
                        <td>{{ $deposit->id }}</td>
                        <td>{{ number_format($deposit->money) }} VNĐ</td>
                      <td>
    @if ($deposit->type === 'nạp tiền')
        Nạp tiền
    @elseif ($deposit->type === 'rút tiền')
        Rút tiền
    @elseif ($deposit->type === 'sản phẩm')
        Sản phẩm
    @else
        Không xác định
    @endif
</td>

                        <td>{{ $deposit->content ?? 'Không có' }}</td>
                        <td>{{ $deposit->status }}</td>
                        <td>{{ $deposit->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
