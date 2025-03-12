@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3>Danh sách rút tiền</h3>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <table class="table table-bordered table-striped" id="user-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ngân hàng</th>
                        <th>Tên tài khoản</th>
                        <th>Số tài khoản</th>
                        <th>Số tiền</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($withdrawals as $withdrawal)
                        <tr>
                            <td>{{ $withdrawal->id }}</td>
                            <td>{{ $withdrawal->bank }}</td>
                            <td>{{ $withdrawal->bankAccName }}</td>
                            <td>{{ $withdrawal->bankAccNum }}</td>
                            <td>{{ number_format($withdrawal->amount, 0, ',', '.') }} VND</td>
                            <td>
                                @if ($withdrawal->status == 'đang chờ')
                                    <span class="badge badge-warning">Đang chờ</span>
                                @elseif ($withdrawal->status == 'thành công')
                                    <span class="badge badge-success">Thành công</span>
                                @elseif ($withdrawal->status == 'thất bại')
                                    <span class="badge badge-danger">Thất bại</span>
                                @endif
                            </td>
                            <td>{{ $withdrawal->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <!-- Nút mở Modal -->
                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#updateStatusModal{{ $withdrawal->id }}">
                                    Cập nhật trạng thái
                                </button>
                            </td>
                        </tr>

                        <!-- Modal -->
                        <div class="modal fade" id="updateStatusModal{{ $withdrawal->id }}" tabindex="-1" role="dialog" aria-labelledby="updateStatusModalLabel{{ $withdrawal->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="updateStatusModalLabel{{ $withdrawal->id }}">Cập nhật trạng thái</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('admin.withdrawals.updateStatus', $withdrawal->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="status">Chọn trạng thái:</label>
                                                <select name="status" id="status" class="form-control">
                                                    <option value="đang chờ" {{ $withdrawal->status == 'đang chờ' ? 'selected' : '' }}>Đang chờ</option>
                                                    <option value="thành công" {{ $withdrawal->status == 'thành công' ? 'selected' : '' }}>Thành công</option>
                                                    <option value="thất bại" {{ $withdrawal->status == 'thất bại' ? 'selected' : '' }}>Thất bại</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

