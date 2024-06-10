<?php
require_once '../../../model/SanPhamModel.php';
require_once '../../../model/LuotXemModel.php';
$lx = new LuotXemModel();
$sp = new SanPhamModel();
$masp = isset($_POST['masp']) ? $_POST['masp'] : 1;
$luotxem__Get_By_Id_Sp = $lx->LuotXem__Get_By_Id($masp);
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
                    <th>Lượt xem</th>
                </tr>
            </thead>
            <tbody>

                <?php $count = 1 ?>
                <?php foreach ($luotxem__Get_By_Id_Sp as $item) : ?>
                    <tr>
                        <td><?= $item->ngayxem ?></td>
                        <td><?= $item->luotxem ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
<script src="../assets/vendor/chart-js-v4.4.1.js"></script>

<script>
    // Line Chart

    var ngayxem = <?php echo json_encode(array_column($luotxem__Get_By_Id_Sp, 'ngayxem')); ?>;
    var luotxem = <?php echo json_encode(array_column($luotxem__Get_By_Id_Sp, 'luotxem')); ?>;

    var lineChartColors = ['#FF6384', '#36A2EB', '#FFCE56', '#4CAF50', '#FF5733'];

    var lineChartCanvas = document.getElementById("lineChart").getContext('2d');
    var lineChartData = {
        labels: ngayxem,
        datasets: [{
            label: "Lượt xem",
            data: luotxem,
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