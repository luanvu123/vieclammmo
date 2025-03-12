@extends('layouts.customer')

@section('content')
    <!-- Page Content-->
    <div class="page-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="row justify-content-center">
                        <div class="col-md-6 col-lg-6">
                            <div class="card bg-corner-img">
                                <div class="card-body">
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-9">
                                            <p class="text-muted text-uppercase mb-0 fw-normal fs-13">Total Revenue</p>
                                            <h4 class="mt-1 mb-0 fw-medium">{{ number_format($totalRevenue, 0, ',', '.') }}
                                                VNĐ</h4>
                                        </div>
                                        <div class="col-3 align-self-center">
                                            <div
                                                class="d-flex justify-content-center align-items-center thumb-md border-dashed border-primary rounded mx-auto">
                                                <i
                                                    class="iconoir-dollar-circle fs-22 align-self-center mb-0 text-primary"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-6">
                            <div class="card bg-corner-img">
                                <div class="card-body">
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-9">
                                            <p class="text-muted text-uppercase mb-0 fw-normal fs-13">New Orders</p>
                                            <h4 class="mt-1 mb-0 fw-medium">{{ $newOrders }}</h4>
                                        </div>
                                        <div class="col-3 align-self-center">
                                            <div
                                                class="d-flex justify-content-center align-items-center thumb-md border-dashed border-info rounded mx-auto">
                                                <i class="iconoir-cart fs-22 align-self-center mb-0 text-info"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h4 class="card-title">Đơn hàng trong 30 ngày</h4>
                                </div><!--end col-->
                            </div> <!--end row-->
                        </div><!--end card-header-->
                        <div class="card-body pt-0">
                            <canvas id="ordersChart" height="100"></canvas>
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div>


                <!-- Thêm thư viện Chart.js -->
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                <script>
                    const completedOrders = @json($completedOrders);
                    const canceledOrders = @json($canceledOrders);

                    const labels = Object.keys(completedOrders).concat(Object.keys(canceledOrders))
                        .filter((value, index, self) => self.indexOf(value) === index)
                        .sort();

                    const completedData = labels.map(date => completedOrders[date] ?? 0);
                    const canceledData = labels.map(date => canceledOrders[date] ?? 0);

                    const ctx = document.getElementById('ordersChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [
                                {
                                    label: 'Đơn hàng thành công',
                                    data: completedData,
                                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    borderWidth: 1
                                },
                                {
                                    label: 'Đơn hàng thất bại',
                                    data: canceledData,
                                    backgroundColor: 'rgba(255, 99, 132, 0.7)',
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    borderWidth: 1
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                x: {
                                    stacked: true
                                },
                                y: {
                                    stacked: true,
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                </script>
@endsection
