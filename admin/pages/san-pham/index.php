<?php
require_once '../model/SanPhamModel.php';
require_once '../model/ThuongHieuModel.php';
require_once '../model/AnhSpModel.php';
$sp = new SanPhamModel();
$th = new ThuongHieuModel();
$anhSp = new AnhSpModel();
$sanPham__Get_All = $sp->SanPham__Get_All(-1);
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
        <div class="col-6">
            <div class="main-data">
                <h3 class="section-title">Danh sách sản phẩm</h3>
                <div class="table-responsive">
                    <table id="table_js" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Ảnh sản phẩm</th>
                                <th>Tên sản phẩm</th>
                                <th>Đơn giá</th>
                                <th>Thương hiệu</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sanPham__Get_All as $item) : ?>
                            <tr>
                                <td><?= $item->masp ?></td>
                                <td><img src="../assets/<?= $anhSp->AnhSp__Get_By_Id_Sp_First($item->masp)->hinhanh?>" alt=""
                                        srcset="" class="img-fluid" width="50"></td>
                                <td><?= $item->tensp ?></td>
                                <td><?= number_format($item->dongia) ?></td>
                                <td><?= $th->ThuongHieu__Get_By_Id($item->math)->tenth ?></td>
                                <td><?= $item->trangthai == 1 ? '<span class="text-success">Hiển thị</span>' : '<span class="text-danger">Tạm ẩn</span>' ?></td>
                                <td class="text-center font-weight-bold">
                                    <button type="button" class="btn btn-primary btn-update"
                                        onclick="return update_anhsp_obj('<?= $item->masp ?>')">
                                        <i class="bx bx-photo-album" aria-hidden="true"></i>
                                    </button>
                                    <button type="button" class="btn btn-warning btn-update"
                                        onclick="return update_obj('<?= $item->masp ?>')">
                                        <i class="bx bx-edit" aria-hidden="true"></i>
                                    </button>
                                    <?php if (isset($_SESSION['admin'])) : ?>
                                    <button type="button" class="btn btn-danger btn-delete"
                                        onclick="return delete_obj('<?= $item->masp ?>')">
                                        <i class="bx bx-trash" aria-hidden="true"></i> 
                                    </button>
                                    <?php endif ?>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="col-6">
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

function update_obj(masp) {
    $.post("pages/san-pham/update.php", {
        masp: masp,
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