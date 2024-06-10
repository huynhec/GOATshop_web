<?php
require_once '../../../model/SanPhamModel.php';
require_once '../../../model/TimeTrackingModel.php';
$ttr = new TimeTrackingModel();
$sp = new SanPhamModel();
$masp = isset($_POST['masp']) ? $_POST['masp'] : 1;
$ttr__Get_By_Id_Sp = $ttr->User_item_tracking__Get_By_Id_Sp($masp);
$sanPham__Get_By_Id = $sp->SanPham__Get_By_Id($masp);

?>

<div class="main-chart update">
    <h4 class="section-title"><?= $sanPham__Get_By_Id->tensp ?></h4>
    <canvas id="lineChart"></canvas>
</div>
<div class="main-data">
    <h4 class="section-title">Chi tiết</h4>
    <input type="hidden" class="form-control" id="masp" name="masp" required value="<?= $sanPham__Get_By_Id->masp ?>">
    <div class="col">
        <label for="tensp" class="form-label">Tên sản phẩm</label>
        <input type="text" class="form-control" id="tensp" name="tensp" required value="<?= $sanPham__Get_By_Id->tensp ?>">
    </div>
    <div class="table-responsive">
        <table id="" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Ngày</th>
                    <th>Thời gian (giây)</th>
                </tr>
            </thead>
            <tbody>

                <?php $count = 1 ?>
                <?php foreach ($ttr__Get_By_Id_Sp as $item) : ?>
                    <tr>
                        <td><?= $item->ngay ?></td>
                        <td><?= $item->thoigian ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
<script src="../assets/vendor/chart-js-v4.4.1.js"></script>

<script>
    // Line Chart

    var ngay = <?php echo json_encode(array_column($ttr__Get_By_Id_Sp, 'ngay')); ?>;
    var thoigian = <?php echo json_encode(array_column($ttr__Get_By_Id_Sp, 'thoigian')); ?>;

    var lineChartColors = ['#FF6384', '#36A2EB', '#FFCE56', '#4CAF50', '#FF5733'];

    var lineChartCanvas = document.getElementById("lineChart").getContext('2d');
    var lineChartData = {
        labels: ngay,
        datasets: [{
            label: "Thời gian (giây)",
            data: thoigian,
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