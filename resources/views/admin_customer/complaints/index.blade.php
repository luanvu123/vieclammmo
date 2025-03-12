@extends('layouts.customer')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                        <h4 class="page-title">Quản lý khiếu nại</h4>
                        <div class="">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('complaints.index') }}">Danh sách khiếu
                                        nại</a></li>
                                <li class="breadcrumb-item active">Quản lý khiếu nại</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Danh sách khiếu nại</h4>
                        </div>
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table class="table mb-0" id="datatable_1">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Khách hàng</th>
                                            <th>Đơn hàng</th>
                                            <th>Nội dung</th>
                                            <th>Trạng thái</th>
                                            <th class="text-end">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($complaints as $key => $complaint)
                                            <tr>
                                                <th>
    {{$key}}
    @if (\Carbon\Carbon::parse($complaint->created_at)->greaterThanOrEqualTo(\Carbon\Carbon::now()->subDay()))
        <span class="badge text-bg-info ms-auto">New</span>
    @endif
</th>
                                                <td><a
                                                        href="{{ route('messages.create', ['customerId' => $complaint->customer_id]) }}">
                                                        {{ $complaint->customer->name}}
                                                    </a></td>
                                                <td><a
                                                        href="{{ route('order-detail.show', $complaint->order->id) }}">{{ $complaint->order->order_key }}</a>
                                                </td>
                                                <td>{{ Str::limit($complaint->content, 50) }}</td>
                                              <td>
    <span class="badge bg-{{ $complaint->status == 'resolved' ? 'success' : 'warning' }}">
        {{ ucfirst($complaint->status) }}
    </span>
</td>
<td class="text-end">
    @if($complaint->status == 'pending')
        <div class="col-auto">
            <button class="btn bg-primary text-white btn-sm" data-bs-toggle="modal" data-bs-target="#editStatusModal{{ $complaint->id }}">
                <i class="fas fa-edit me-1"></i>
            </button>
        </div>
    @endif

    <form action="{{ route('complaints.destroy', $complaint->id) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
    </form>
</td>


<!-- Edit Status Modal -->
<div class="modal fade" id="editStatusModal{{ $complaint->id }}" tabindex="-1" aria-labelledby="editStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('complaints.update-status', $complaint->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="editStatusModalLabel">Cập nhật trạng thái khiếu nại</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="status">Trạng thái khiếu nại</label>
                        <select name="status" class="form-control" required>
                            <option value="pending" {{ $complaint->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="resolved" {{ $complaint->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">Cập nhật trạng thái</button>
                </div>
            </form>
        </div>
    </div>
</div>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
