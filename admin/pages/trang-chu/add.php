<?php

require_once("../model/ChiTietDonHangModel.php");
$ctdh = new ChiTietDonHangModel();

echo $startDate = date('Y-m-d', strtotime('-1 month'));
echo $endDate = date('Y-m-d');
$chiTietDonHang__Doanh_Thu_Chart = $ctdh->ChiThietDonHang__Doanh_Thu_Chart($startDate, $endDate);
?>

<div class="main-chart update">
    <canvas id="lineChart"></canvas>
</div>
<div class="main-data">
    <h3 class="section-title">Doanh Thu</h3>
    <div class="table-responsive">
        <table id="" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Top</th>
                    <th>Ngày</th>
                    <th>Tổng số tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($chiTietDonHang__Doanh_Thu_Chart) < 1) : ?>
                    <tr>
                        <td>Không có dữ liệu</td>
                    </tr>
                <?php endif ?>
                <?php $count = 1 ?>
                <?php foreach ($chiTietDonHang__Doanh_Thu_Chart as $item) : ?>
                    <tr>
                        <td><?= $count++ ?></td>
                        <td><?= $item->ngaythem ?></td>
                        <td><?= number_format($item->sum_doanhthu) ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
<script src="../assets/vendor/chart-js-v4.4.1.js"></script>

<script>
    // Line Chart

    var ngaythem = <?php echo json_encode(array_column($chiTietDonHang__Doanh_Thu_Chart, 'ngaythem')); ?>;
    var sum_doanhthu = <?php echo json_encode(array_column($chiTietDonHang__Doanh_Thu_Chart, 'sum_doanhthu')); ?>;

    var lineChartColors = ['#FF6384', '#36A2EB', '#FFCE56', '#4CAF50', '#FF5733'];

    var lineChartCanvas = document.getElementById("lineChart").getContext('2d');
    var lineChartData = {
        labels: ngaythem,
        datasets: [{
            label: "Doanh thu",
            data: sum_doanhthu,
            backgroundColor: lineChartColors,
            borderColor: lineChartColors,
            borderWidth: 1
        }]
    };
    var lineChartOptions = {
        responsive: true,
    };
    var myPieChart = new Chart(lineChartCanvas, {
        type: 'line',
        data: lineChartData,
        options: lineChartOptions
    });
</script>