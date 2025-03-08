@extends('layout')
@section('content')
    <div class="profile-container">

        <!-- Profile Left -->
        <div class="profile-left">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="position-relative me-3">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                style="width: 50px; height: 50px; font-weight: bold;">
                                LV 22
                            </div>
                            <div class="progress mt-1" style="height: 10px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 45%;"
                                    aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        @if (isset($customer))
                            <h5 class="mb-0">{{ '@' . $customer->name }}
                                @if ($customer->email == 'bgntmrqph24111516@vnetwork.io.vn')
                                    <i class="fa fa-check-circle" style="color:red; font-size: 80%;"
                                        title="Thuộc hệ thống"></i>
                                @endif
                            </h5>
                        @endif
                        @if (isset($isWarned) && $isWarned)
                            <span class="text-danger ms-2"><i class="fa fa-exclamation-circle"></i></span>
                        @endif
                    </div>

                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td width="30%">Tài khoản</td>
                                <td>{{ '@' . $customer->name }}
                                    @if ($customer->email == 'bgntmrqph24111516@vnetwork.io.vn')
                                        <i class="fa fa-check-circle" style="color:red; font-size: 80%;"
                                            title="Thuộc hệ thống"></i>
                                    @endif

                                </td>
                            </tr>
                            <tr>
                                <td>Ngày đăng ký</td>
                                <td>{{ $customer->created_at->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td>Đã mua</td>
                                <td>{{ $productsBought }} sản phẩm</td>
                            </tr>
                            <tr>
                                <td>Số gian hàng</td>
                                <td>{{ $storesCount }} gian hàng</td>
                            </tr>
                            <tr>
                                <td>Đã bán</td>
                                <td>{{ $productsSold }} sản phẩm</td>
                            </tr>
                            <tr>
                                <td>Số bài viết</td>
                                <td>{{ $postsCount }} bài viết</td>
                            </tr>
                            <tr>
                                <td>Kết nối Telegram</td>
                                <td>
                                    @if ($customer->isTelegram)
                                        <span class="text-success"><i class="fa fa-check-circle"></i> Đã kết nối</span>
                                        <div class="text-muted small">(Người dùng sẽ nhận được tin nhắn của bạn qua Telegram
                                            nếu có kết nối)</div>
                                    @else
                                        <span class="text-danger">Chưa kết nối</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Định danh eKYC</td>
                                <td>
                                    @if ($customer->isEkyc)
                                        <span class="text-success"><i class="fa fa-check-circle"></i> Đã xác thực
                                            eKYC</span>
                                    @else
                                        <span class="text-danger">Chưa xác thực</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Profile Right -->
        <div class="profile-right">
            <div class="card text-center">
                <div class="card-body">
                    <div class="mb-3">
                        <img src="{{
    $customer->email == 'bgntmrqph24111516@vnetwork.io.vn'
        ? asset('img/admin-icon.png')
        : ($customer->avatar ? asset('storage/' . $customer->avatar) : asset('img/user-icon.png'))
}}"
class="rounded-circle img-thumbnail" style="width: 120px; height: 120px;">

                    </div>
                    <h5 class="mb-2">{{ '@' . $customer->name }}<i class="fa fa-check-circle"
                            style="color:red; font-size: 80%;" title="Thuộc hệ thống"></i></h5>
                    <p class="text-muted small">Online {{ $lastActiveTime ?? 'hiện tại' }}</p>

                    <div class="d-flex justify-content-center mt-3">

                        <a href="{{ route('messages.create', ['customerId' => $customer->id]) }}"
                            class="btn btn-outline-primary">Nhắn tin</a>



                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
