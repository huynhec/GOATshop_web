<?php
require_once '../model/SanPhamModel.php';
require_once '../model/LuotXemModel.php';
require_once '../model/AnhSpModel.php';

$lx = new LuotXemModel();
$sp = new SanPhamModel();
$anhSp = new AnhSpModel();

$luotxem__Get_Alls = $lx->LuotXem__Get_Alls();
?>

<div id="main-container">
    <div class="main-title">
        <h3>Quản lý lượt xem</h3>
        <ul class="breadcrumb">
            <li>
                <a href="#">Quản lý lượt xem</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active" href="index.php?pages=thoi-gian-theo-doi">Danh sách lượt xem</a>
            </li>
        </ul>
    </div>
    <div class="row section-container">
        <div class="col-7">
            <div class="main-data">
                <a href="pages/luot-xem/action.php?req=export" class="btn btn-danger float-right">EXPORT</a>
                <h3 class="section-title">Danh sách lượt xem</h3>
                <div class="table-responsive">
                    <table id="table_js" class="table table-striped" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Ảnh sản phẩm</th>
                                <th>Tên sản phẩm</th>
                                <th>Lượt xem</th>
                                <th>Ngày xem</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($luotxem__Get_Alls as $key => $item) : ?>
                                <input type="hidden" id="masp_1" value="<?= $key == 0 ? $item->masp : 0 ?>">
                                <tr onclick="return luotxem_chart('<?= $item->masp ?>')" style="cursor:pointer; ">
                                    <td><?= $item->idlx ?></td>
                                    <td><img style="cursor:pointer; " src="../assets/<?= $anhSp->AnhSp__Get_By_Id_Sp_First($item->masp)->hinhanh ?>" alt="" srcset="" class="img-fluid" width="50"></td>
                                    <td>
                                        <span data-toggle="tooltip" title="<?= $sp->SanPham__Get_By_Id($item->masp)->tensp ?>">
                                            <?= strlen($sp->SanPham__Get_By_Id($item->masp)->tensp) > 60 ? substr($sp->SanPham__Get_By_Id($item->masp)->tensp, 0, 60) . '...' : $sp->SanPham__Get_By_Id($item->masp)->tensp ?>
                                        </span>
                                    </td>
                                    <td><?= $item->luotxem ?>
                                    </td>
                                    <td><?= $item->ngayxem ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="main-form">
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('load', function() {
        document.getElementById('dynamicTitle').innerText = "ADMIN | Quản lý thời gian theo dõi";
        masp_1 = document.getElementById('masp_1').value;
        luotxem_chart(masp_1)
    })

    function luotxem_chart(masp) {
        $.post("pages/luot-xem/luotxem_chart.php", {
            masp: masp,
        }, function(data, status) {
            $(".main-form").html(data);
        });
    };
</script>