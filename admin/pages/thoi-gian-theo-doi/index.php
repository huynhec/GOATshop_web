<?php
require_once '../model/SanPhamModel.php';
require_once '../model/TimeTrackingModel.php';
require_once '../model/AnhSpModel.php';

$ttr = new TimeTrackingModel();
$sp = new SanPhamModel();
$anhSp = new AnhSpModel();

$timeTracking__Get_All = $ttr->User_item_tracking__Get_All();
$timeTracking__Get_OneD = $ttr->User_item_tracking__Get_OneD();
$timeTracking__Get_TwoD = $ttr->User_item_tracking__Get_TwoD();
?>

<div id="main-container">
    <div class="main-title">
        <h3>Quản lý thời gian theo dõi</h3>
        <ul class="breadcrumb">
            <li>
                <a href="#">Quản lý thời gian theo dõi</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active" href="index.php?pages=thoi-gian-theo-doi">Danh sách theo dõi</a>
            </li>
        </ul>
    </div>
    <div class="row section-container">
        <div class="col-7">
            <div class="main-data">
                <h3 class="section-title">Danh sách theo dõi</h3>
                <div class="table-responsive">
                    <table id="table_js" class="table table-striped" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Ảnh sản phẩm</th>
                                <th>Tên sản phẩm</th>
                                <th>Loại theo dõi</th>
                                <th>Thời gian</th>
                                <th>Ngày</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- nếu nhấn button 1 thì sẽ ngày foreach này -->
                        <!-- <?php foreach ($timeTracking__Get_OneD as $item) : ?>
                            <tr data-type="1day">
                                    <td><?= $item->uitrack_id ?></td>
                                    <td><img style="cursor:pointer; " src="../assets/<?= $anhSp->AnhSp__Get_By_Id_Sp_First($item->masp)->hinhanh ?>" alt="" srcset="" class="img-fluid" width="50" onclick="return trackingitem_chart('<?= $item->masp ?>')"></td>
                                    <td>
                                        <span data-toggle="tooltip" title="<?= $sp->SanPham__Get_By_Id($item->masp)->tensp ?>">
                                            <?= strlen($sp->SanPham__Get_By_Id($item->masp)->tensp) > 60 ? substr($sp->SanPham__Get_By_Id($item->masp)->tensp, 0, 60) . '...' : $sp->SanPham__Get_By_Id($item->masp)->tensp ?>
                                        </span>
                                    </td>
                                    <td><?= $item->typetrack == 1 ? '<span class="text-success">Quan tâm</span>' : '<span class="text-warning">Vãng lai</span>' ?>
                                    </td>
                                    <td><?= $item->thoigian ?> giây</td>
                                    <td><?= $item->ngay ?></td>
                                </tr>
                            <?php endforeach ?>
                            <?php foreach ($timeTracking__Get_TwoD as $item) : ?>
                                <tr data-type="2days">
                                    <td><?= $item->uitrack_id ?></td>
                                    <td><img style="cursor:pointer; " src="../assets/<?= $anhSp->AnhSp__Get_By_Id_Sp_First($item->masp)->hinhanh ?>" alt="" srcset="" class="img-fluid" width="50" onclick="return trackingitem_chart('<?= $item->masp ?>')"></td>
                                    <td>
                                        <span data-toggle="tooltip" title="<?= $sp->SanPham__Get_By_Id($item->masp)->tensp ?>">
                                            <?= strlen($sp->SanPham__Get_By_Id($item->masp)->tensp) > 60 ? substr($sp->SanPham__Get_By_Id($item->masp)->tensp, 0, 60) . '...' : $sp->SanPham__Get_By_Id($item->masp)->tensp ?>
                                        </span>
                                    </td>
                                    <td><?= $item->typetrack == 1 ? '<span class="text-success">Quan tâm</span>' : '<span class="text-warning">Vãng lai</span>' ?>
                                    </td>
                                    <td><?= $item->thoigian ?> giây</td>
                                    <td><?= $item->ngay ?></td>
                                </tr>
                            <?php endforeach ?> -->
                             <?php foreach ($timeTracking__Get_All as $item) : ?>
                                <tr>
                                    <td><?= $item->uitrack_id ?></td>
                                    <td><img style="cursor:pointer; " src="../assets/<?= $anhSp->AnhSp__Get_By_Id_Sp_First($item->masp)->hinhanh ?>" alt="" srcset="" class="img-fluid" width="50" onclick="return trackingitem_chart('<?= $item->masp ?>')"></td>
                                    <td>
                                        <span data-toggle="tooltip" title="<?= $sp->SanPham__Get_By_Id($item->masp)->tensp ?>">
                                            <?= strlen($sp->SanPham__Get_By_Id($item->masp)->tensp) > 60 ? substr($sp->SanPham__Get_By_Id($item->masp)->tensp, 0, 60) . '...' : $sp->SanPham__Get_By_Id($item->masp)->tensp ?>
                                        </span>
                                    </td>
                                    <td><?= $item->typetrack == 1 ? '<span class="text-success">Quan tâm</span>' : '<span class="text-warning">Vãng lai</span>' ?>
                                    </td>
                                    <td><?= $item->thoigian ?> giây</td>
                                    <td><?= $item->ngay ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="main-form">
                <!-- <button>1 ngày</button> <button>2 ngày</button> -->
            </div>
        </div>

</div>

<script>
    window.addEventListener('load', function() {
        document.getElementById('dynamicTitle').innerText = "ADMIN | Quản lý thời gian theo dõi";
    })


    function trackingitem_chart(masp) {
        $.post("pages/thoi-gian-theo-doi/trackingitem_chart.php", {
            masp: masp,
        }, function(data, status) {
            $(".main-form").html(data);
        });
    };
</script>