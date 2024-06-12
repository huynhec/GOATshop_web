<?php
require_once '../model/ChiTietDonHangModel.php';
require_once '../model/CommonModel.php';


$ctdh = new ChiTietDonHangModel();
$cm = new CommonModel();

if (isset($_POST['startDate'])) {
    $startDate = $_POST['startDate'];
} else {
    $startDate = date('Y-m-d', strtotime('-1 month'));
}
if (isset($_POST['endDate'])) {
    $endDate = $_POST['endDate'];
} else {
    $endDate = date('Y-m-d');
}

$chiTietDonHang__Top_Ban_Chart = $ctdh->ChiThietDonHang__Top_Ban_Chart();
$chiThietDonHang__So_Mat_Hang = $ctdh->ChiThietDonHang__So_Mat_Hang();
$chiThietDonHang__Tong_Danh_Thu = $ctdh->ChiThietDonHang__Tong_Danh_Thu();
$chiThietDonHang__So_Mat_Hang_By_Date = $ctdh->ChiThietDonHang__So_Mat_Hang_By_Date($startDate, $endDate);
$chiThietDonHang__Tong_Danh_Thu_By_Date = $ctdh->ChiThietDonHang__Tong_Danh_Thu_By_Date($startDate, $endDate);
?>
<style>
    .stats-container {
        display: flex;
        justify-content: space-between;
    }

    .stats-section {
        width: 50%;
    }
</style>
<div id="main-container">
    <div class="main-title">
        <h3>Thống kê</h3>
        <div class="stats-container">
            <div class="stats-section">
                <h5>Một tháng gần nhất</h5>
                <ul>
                    <li>Tổng mặt hàng đã bán: <?= $chiThietDonHang__So_Mat_Hang_By_Date ?></li>
                    <li>Tổng doanh thu: <?= number_format($chiThietDonHang__Tong_Danh_Thu_By_Date->tong_doanhthu) ?> ₫</li>
                </ul>
            </div>
            <div class="stats-section">
                <h5>Từ trước đến nay</h5>
                <ul>
                    <li>Tổng mặt hàng đã bán: <?= $chiThietDonHang__So_Mat_Hang ?></li>
                    <li>Tổng doanh thu: <?= number_format($chiThietDonHang__Tong_Danh_Thu->tong_doanhthu) ?> ₫</li>
                </ul>
            </div>
        </div>
        <a href="pages/trang-chu/action.php?req=export" class="btn btn-danger float-right">EXPORT</a>

    </div>

    <hr>
    <div class="row section-container">

        <div class="col-7">
            <input type="text" name="daterange" id="daterange" value="<?= date('m/d/Y', strtotime('-1 month')) ?> - <?= date('m/d/Y') ?>" class="form-control" />
            <div class="main-form">
                <?php require 'add.php'; ?>
            </div>
        </div>

        <div class="col-5">
            <div class="main-chart">
                <canvas id="barChart"></canvas>
            </div>
            <div class="main-data">
                <h3 class="section-title">Top sản phẩm bán chạy</h3>
                <div class="table-responsive">
                    <table id="" class="table table-striped" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>Top</th>
                                <th>Tên sản phẩm</th>
                                <th>Số lượng bán</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1 ?>
                            <?php foreach ($chiTietDonHang__Top_Ban_Chart as $item) : ?>
                                <tr>
                                    <td><?= $count++ ?></td>
                                    <td><?= $item->tensp ?></td>
                                    <td><?= $cm->formatThousand($item->sum_soluong) ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
<script src="../assets/vendor/chart-js-v4.4.1.js"></script>
<script>
    // Bar Chart
    var barChartCanvas = document.getElementById("barChart").getContext('2d');

    var tensp = <?php echo json_encode(array_column($chiTietDonHang__Top_Ban_Chart, 'tensp')); ?>;
    var sum_soluong = <?php echo json_encode(array_column($chiTietDonHang__Top_Ban_Chart, 'sum_soluong')); ?>;
    var barChartColors = ['#FF6384', '#36A2EB', '#FFCE56', '#4CAF50', '#FF5733'];

    var barChartData = {
        labels: tensp,
        datasets: [{
            label: 'Top lượt bán',
            data: sum_soluong,
            backgroundColor: barChartColors,
            borderColor: 'white',
            borderWidth: 1
        }]
    };

    var barChartOptions = {
        scales: {
            y: {
                beginAtZero: true
            },
            x: {
                display: false // Hide the x-axis labels
            }
        },
        plugins: {
            legend: {
                display: false
            }
        },
        responsive: true,
        maintainAspectRatio: false
    };

    var myBarChart = new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions,
        plugins: [{
            afterDraw: function(chart) {
                var ctx = chart.ctx;
                var xAxis = chart.scales.x;

                chart.data.labels.forEach(function(label, index) {
                    var x = xAxis.getPixelForValue(index);
                    var y = chart.scales.y.getPixelForValue(chart.data.datasets[0].data[index]);
                    var barWidth = chart.width / tensp.length;

                    var text = "Top " + (index + 1);
                    var fontSize = 14;
                    ctx.fillStyle = 'black';
                    ctx.font = fontSize + 'px Roboto';
                    ctx.textAlign = 'center';
                    ctx.fillText(text, x - barWidth / 2 + barWidth / 2, y + 10);
                });
            }
        }]
    });
</script>