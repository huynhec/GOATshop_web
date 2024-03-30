<?php

require_once("../model/DonGiaModel.php");
$dg = new DonGiaModel();
$dongia__Get_By_Id_Sp = $dongia->DonGia__Get_By_Id_Sp($masp);


?>

<div class="main-chart update">
    <canvas id="lineChart"></canvas>
</div>
<div class="main-data">
    <h3 class="section-title">Biểu đồ</h3>
    <div class="table-responsive">
        <table id="" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Ngày</th>
                    <th>Đơn giá</th>
                </tr>
            </thead>
            <tbody>

                <?php $count = 1 ?>
                <?php foreach ($dongia__Get_By_Id_Sp as $item) : ?>
                    <tr>
                        <td><?= $item->ngaythem ?></td>
                        <td><?= $item->dongia ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
<script src="../assets/vendor/chart-js-v4.4.1.js"></script>

<script>
    // Line Chart

    var ngaythem = <?php echo json_encode(array_column($dongia__Get_By_Id_Sp, 'ngaythem')); ?>;
    var dg_dongia = <?php echo json_encode(array_column($dongia__Get_By_Id_Sp, 'dongia')); ?>;

    var lineChartColors = ['#FF6384', '#36A2EB', '#FFCE56', '#4CAF50', '#FF5733'];

    var lineChartCanvas = document.getElementById("lineChart").getContext('2d');
    var lineChartData = {
        labels: ngaythem,
        datasets: [{
            label: "Đơn giá",
            data: dg_dongia,
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