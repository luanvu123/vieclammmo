@extends('layout')

@section('content')
<style>

    .btn {
        padding: 8px 16px;
        background-color: #4f46e5;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        transition: background-color 0.3s;
        display: inline-block;
    }

    .btn:hover {
        background-color: #4338ca;
    }

    .table-auto {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .table-auto th, .table-auto td {
        padding: 12px;
        border: 1px solid #d1d5db;
        text-align: left;
    }

    .table-auto th {
        background-color: #e5e7eb;
    }

    .text-green-custom {
        color: #16a34a;
        font-weight: bold;
    }

    .text-red-custom {
        color: #dc2626;
        font-weight: bold;
    }

    .text-yellow-custom {
        color: #f59e0b;
        font-weight: bold;
    }
</style>

    <div class="post-container">
        <h1 class="text-xl font-bold mb-4">Lịch sử thanh toán</h1>

        {{-- Nút yêu cầu rút tiền --}}
        <div class="mb-4">
            <a href="{{ route('withdrawals.create') }}" class="btn btn-primary">Yêu cầu rút tiền</a>
        </div>
        <div class="mb-4">
            <a href="{{ route('withdrawals.index') }}" class="btn btn-primary">Rút tiền</a>
        </div>

        {{-- Danh sách giao dịch nạp tiền --}}
        @if ($deposits->count() > 0)
            <table class="table-auto w-full border-collapse border border-gray-300 mb-5" id="user-table">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 px-4 py-2">Số tiền</th>
                        <th class="border border-gray-300 px-4 py-2">Loại</th>
                        <th class="border border-gray-300 px-4 py-2">Nội dung</th>
                        <th class="border border-gray-300 px-4 py-2">Trạng thái</th>
                        <th class="border border-gray-300 px-4 py-2">Ngày giao dịch</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($deposits as $deposit)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2
                                        @if ($deposit->type == 'bán hàng') text-green-custom
                                        @elseif ($deposit->type == 'mua hàng') text-red-custom
                                        @endif">

                                @if ($deposit->type == 'bán hàng')
                                    + {{ number_format($deposit->money, 0, ',', '.') }} VND
                                @elseif ($deposit->type == 'mua hàng')
                                    - {{ number_format($deposit->money, 0, ',', '.') }} VND
                                @else
                                    {{ number_format($deposit->money, 0, ',', '.') }} VND
                                @endif
                            </td>
                            <td class="border border-gray-300 px-4 py-2">{{ $deposit->type }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $deposit->content }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                @if ($deposit->status == 'thành công')
                                    <span class="text-green-custom">Hoàn thành</span>
                                @elseif ($deposit->status == 'đang chờ')
                                    <span class="text-yellow-custom">Đang chờ</span>
                                @elseif ($deposit->status == 'thất bại')
                                    <span class="text-red-custom">Thất bại</span>
                                @endif
                            </td>
                            <td class="border border-gray-300 px-4 py-2">{{ $deposit->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Không có giao dịch nào được tìm thấy.</p>
        @endif
    </div>
@endsection
