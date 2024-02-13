
<div id="main-container">
    <div class="main-title">
        <h3>Thống kê</h3>
        <ul class="breadcrumb">
            <li>
                <a href="#">Thống kê</a>
            </li>
        </ul>
    </div>

    <hr>
    <div class="row section-container">

        <div class="col-6">
            <input type="text" name="daterange" id="daterange" value="<?= date('m/d/Y', strtotime('-1 month')) ?> - <?= date('m/d/Y') ?>" class="form-control" />
            <div class="main-form">
                <!-- <?php require 'add.php'; ?> -->
            </div>
        </div>

        <div class="col-6">
            <div class="main-chart">
                <canvas id="barChart"></canvas>
            </div>
            <div class="main-data">
                <h3 class="section-title">Top sản phẩm bán chạy</h3>
                <div class="table-responsive">
                    <table id="" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Top</th>
                                <th>Tên sản phẩm</th>
                                <th>Số lượng bán</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 0 ?>
                            <!-- <?php foreach ($chiTietDonHang__Top_Ban_Chart as $item) : ?> -->
                                <tr>
                                    <td><?= $count++ ?></td>
                                    <td><?= $item->tensp ?></td>
                                    <td><?= $cm->formatThousand($item->sum_soluong) ?></td>
                                </tr>
                            <!-- <?php endforeach ?> -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
