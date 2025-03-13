@extends('layouts.app')

@section('title', 'Quản lý khách hàng')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <table id="user-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Mã KH</th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>SĐT</th>
                            <th>Số dư</th>
                            <th>Trạng thái</th>
                            <th>eKYC</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $customer)
                            <tr>
                                <td>{{ $customer->id }}
                                    @if (\Carbon\Carbon::parse($customer->created_at)->greaterThanOrEqualTo(\Carbon\Carbon::now()->subDay()))
                                        <span class="label label-primary pull-right">New</span>
                                    @endif
                                </td>
                                <td>{{ $customer->idCustomer }}</td>

                                <td>

                                    <a href="{{ route('messages.create', ['customerId' => $customer->id]) }}"
                                        class="text-primary">
                                        {{ $customer->name }}
                                    </a>

                                    @if ($customer->email == 'bgntmrqph24111516@vnetwork.io.vn')
                                        <i class="fa fa-check-circle" style="color:red; font-size: 80%;" title="Thuộc hệ thống"></i>
                                    @endif
                                </td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->phone }}</td>
                                <td>{{ number_format($customer->Balance) }} VNĐ</td>
                                <td>
                                    <span class="badge {{ $customer->Status ? 'badge-success' : 'badge-danger' }}">
                                        {{ $customer->Status ? 'Hoạt động' : 'Bị khóa' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $customer->isEkyc ? 'badge-success' : 'badge-warning' }}">
                                        {{ $customer->isEkyc ? 'Đã xác thực' : 'Chưa xác thực' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('customer-manage.edit', $customer->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i> Sửa
                                    </a>

                                    <!-- Nút Nạp/Rút tiền -->
                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                        data-target="#depositModal" data-id="{{ $customer->id }}">
                                        Nạp/Rút tiền
                                    </button>

                                    <!-- Nút Lịch sử giao dịch -->
                                    <a href="{{ route('customer-manage.deposits', $customer->id) }}"
                                        class="btn btn-info btn-sm">
                                        <i class="fas fa-history"></i> Lịch sử giao dịch
                                    </a>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Nạp/Rút tiền -->
    <div class="modal fade" id="depositModal" tabindex="-1" role="dialog" aria-labelledby="depositModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('customer-manage.storeDeposit') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="depositModalLabel">Nạp/Rút tiền</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="customer_id" id="customer_id">
                        <div class="form-group">
                            <label for="money">Số tiền:</label>
                            <input type="number" class="form-control" name="money" required>
                        </div>
                        <div class="form-group">
                            <label for="type">Loại giao dịch:</label>
                            <select class="form-control" name="type" required>
                                <option value="nạp tiền">Nạp tiền</option>
                                <option value="rút tiền">Rút tiền</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="content">Nội dung:</label>
                            <textarea class="form-control" name="content"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Xác nhận</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $('#depositModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var customerId = button.data('id');
            var modal = $(this);
            modal.find('#customer_id').val(customerId);
        });
    </script>
@endsection
