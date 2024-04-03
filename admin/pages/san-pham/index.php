<?php
require_once '../model/SanPhamModel.php';
require_once '../model/ThuongHieuModel.php';
require_once '../model/AnhSpModel.php';
require_once '../model/ThuocTinhModel.php';
require_once '../model/DonGiaModel.php';

$dg = new DonGiaModel();
$sp = new SanPhamModel();
$th = new ThuongHieuModel();
$anhSp = new AnhSpModel();
$tt = new ThuocTinhModel();
$sanPham__Get_All = $sp->SanPham__Get_All(-1);
$donGia__Get_All = $dg->DonGia__Get_All();
?>

<div id="main-container">
    <div class="main-title">
        <h3>Quản lý sản phẩm</h3>
        <ul class="breadcrumb">
            <li>
                <a href="#">Quản lý sản phẩm</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active" href="index.php?pages=san-pham">Danh sách sản phẩm</a>
            </li>
        </ul>
    </div>
    <div class="row section-container">
        <div class="col-7">
            <div class="main-data">
                <h3 class="section-title">Danh sách sản phẩm</h3>
                <div class="table-responsive">
                    <table id="table_js" class="table table-striped" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Ảnh sản phẩm</th>
                                <th>Tên sản phẩm</th>
                                <th>Thương hiệu</th>
                                <th>Đơn giá</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sanPham__Get_All as $item) : ?>
                                <tr id="product_<?php echo $item->masp; ?>">
                                    <td><?= $item->masp ?></td>
                                    <td><img src="../assets/<?= $anhSp->AnhSp__Get_By_Id_Sp_First($item->masp)->hinhanh ?>" alt="" srcset="" class="img-fluid" width="50"></td>
                                    <td><?= $item->tensp ?></td>
                                    <td>
                                        <a href="index.php?pages=thuong-hieu">
                                            <button class="btn btn-outline-primary">
                                                <?= $th->ThuongHieu__Get_By_Id($item->math)->tenth ?>
                                            </button>
                                        </a>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-update" onclick="return dg_update_obj('<?= $item->masp ?>')">
                                            <?= number_format($dg->ShowDonGia__Get_By_Id_Spdg($item->masp))  ?>₫
                                            <i class="bx bx-edit" aria-hidden="true"></i>
                                        </button>
                                    </td>
                                    <td><?= $item->trangthai == 1 ? '<span class="text-success">Hiển thị</span>' : '<span class="text-danger">Tạm ẩn</span>' ?>
                                    </td>
                                    <td class="text-center font-weight-bold">
                                        <button type="button" class="btn btn-primary btn-update" onclick="return update_anhsp_obj('<?= $item->masp ?>')">
                                            <i class="bx bx-photo-album" aria-hidden="true"></i>
                                        </button>
                                        <button type="button" class="btn btn-warning btn-update" onclick="return update_obj('<?= $item->masp ?>','<?= $item->maloai ?>')">
                                            <i class="bx bx-edit" aria-hidden="true"></i>
                                        </button>
                                        <?php if (isset($_SESSION['admin'])) : ?>
                                            <!-- <button type="button" class="btn btn-danger btn-delete"
                                        onclick="return delete_obj('<?= $item->masp ?>')">
                                        <i class="bx bx-trash" aria-hidden="true"></i> 
                                    </button> -->
                                        <?php endif ?>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="col-5">
            <div class="main-form">
                <?php require_once 'add.php' ?>
            </div>
        </div>
    </div>
</div>

<script>  
    function update_anhsp_obj(masp) {
        location.href = "index.php?pages=anh-san-pham&masp=" + masp;
    };

    function dg_update_obj(masp) {
        location.href = "index.php?pages=dongia-san-pham&masp=" + masp;
    };

    function update_obj(masp, maloai) {
        $.post("pages/san-pham/update.php", {
            masp: masp,
            maloai: maloai,
        }, function(data, status) {
            $(".main-form").html(data);
        });
    };

    function delete_obj(masp) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "m-2 btn btn-danger",
                cancelButton: "m-2 btn btn-secondary"
            },
            buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
            title: "Xác nhận thao tác",
            text: "Chắc chắn xóa!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Xóa!",
            cancelButtonText: "Hủy!",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                location.href = "pages/san-pham/action.php?req=delete&masp=" + masp;
            } else if (
                result.dismiss === Swal.DismissReason.cancel
            );
        });
    };
    window.addEventListener('load', function() {
        document.getElementById('dynamicTitle').innerText = "ADMIN | Quản lý sản phẩm";
    })
</script>