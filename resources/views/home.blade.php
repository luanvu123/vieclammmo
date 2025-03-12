@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <h4>Tổng doanh thu: {{ number_format($totalRevenue, 0, ',', '.') }} VNĐ</h4>

                    <!-- Thêm phần tử <canvas> -->
                    <canvas id="ordersChart" style="height: 400px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Thêm thư viện Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Kiểm tra dữ liệu truyền từ controller
    console.log("Completed Orders:", @json($completedOrders));
    console.log("Canceled Orders:", @json($canceledOrders));

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

