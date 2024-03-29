<?php
require_once '../model/ThuocTinhModel.php';
require_once '../model/LoaiSpModel.php';
$loaiSp = new LoaiSpModel();
$tt = new ThuocTinhModel();
$thuoctinh__Get_All = $tt->ThuocTinh__Get_All(-1);
$loaiSp__Get_All = $loaiSp->LoaiSp__Get_All();
$loaisp__Get_All_Exist = $loaiSp->LoaiSp__Get_All_Exist();
?>

<div id="main-container">
    <div class="main-title">
        <h3>Quản lý thuộc tính</h3>
        <ul class="breadcrumb">
            <li>
                <a href="#">Quản lý thuộc tính</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active" href="index.php?pages=thuoc-tinh">Danh sách thuộc tính</a>
            </li>
        </ul>
    </div>
    <div class="row section-container">
        <div class="col-5">
            <div class="main-data">

                <h3 class="section-title">Danh sách thuộc tính theo loại</h3>
                <div class="table-responsive">
                    <table id="table_js1" class="table table-striped table-light" style="width:100%">
                        <thead class="thead-dark">
                            <tr>
                                <th>Tên loại</th>
                                <!-- <th>Trạng thái</th> -->
                                <th class="text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($loaisp__Get_All_Exist as $item) : ?>
                            <tr data-bs-toggle="collapse" data-bs-target="#collapse<?= $item->maloai ?>"
                                aria-expanded="false" aria-controls="collapse<?= $item->maloai ?>">

                                <td>
                                    <?= $item->tenloai ?>
                                </td>
                                <!-- <td><?= $item->trangthai == 1 ? '<span class="text-success">Hoạt động</span>' : '<span class="text-danger">Tạm khóa</span>' ?>
                                </td> -->
                                <td class="text-center font-weight-bold">
                                    <button type="button" class="btn btn-warning btn-update"
                                        onclick="return l_update_obj('<?= $item->maloai ?>',<?= $item->idtt ?>)">
                                        <i class="bx bx-edit" aria-hidden="true"></i> Sửa
                                        <i class='bx bx-caret-down' aria-hidden="true"></i>

                                    </button>
                                    <?php if (isset($_SESSION['admin'])) : ?>
                                    <!-- <button type="button" class="btn btn-danger btn-delete" onclick="return delete_obj('<?= $item->maloai ?>')">
                                                <i class="bx bx-trash" aria-hidden="true"></i> Xóa
                                            </button> -->
                                    <?php endif ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="p-0">
                                    <div class="collapse" id="collapse<?= $item->maloai ?>">
                                        <table class="table table-striped">
                                            <!-- <thead class="thead-light">
                                                    <tr>
                                                        <th>Tên thuộc tính</th>
                                                        <th>Trạng thái</th>
                                                        <th>Thao tác</th>

                                                    </tr>
                                                </thead> -->
                                            <tbody>
                                                <?php foreach ($thuoctinh__Get_All as $thuoctinh) : ?>
                                                <?php if ($thuoctinh->maloai == $item->maloai) : ?>
                                                <i class="bi bi-arrow-return-right"></i>

                                                <tr class="sub">
                                                    <td> --
                                                        <?= $thuoctinh->tentt ?>
                                                    </td>
                                                    <td><?= $thuoctinh->trangthai == 1 ? '<span class="text-success">Hoạt động</span>' : '<span class="text-danger">Tạm khóa</span>' ?>
                                                    </td>
                                                    <!-- <td class="text-center font-weight-bold">
                                                        <button type="button" class="btn btn-warning btn-update"
                                                            onclick="return update_obj('<?= $thuoctinh->idtt ?>')">
                                                            <i class="bx bx-edit" aria-hidden="true"></i> Sửa
                                                        </button>
                                                        <?php if (isset($_SESSION['admin'])) : ?>
                                                        <button type="button" class="btn btn-danger btn-delete" onclick="return delete_obj('<?= $item->idtt ?>')">
                                                                            <i class="bx bx-trash" aria-hidden="true"></i> Xóa
                                                                        </button>
                                                        <?php endif ?>

                                                    </td> -->
                                                </tr>
                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>

                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="col-7">
            <div class="main-form">
                <?php require_once 'add.php' ?>
            </div>
        </div>
    </div>
</div>

<script>
function l_update_obj(maloai, idtt) {
    $.post("pages/thuoc-tinh/l_update.php", {
        maloai: maloai,
        idtt: idtt
    }, function(data, status) {
        $(".main-form").html(data);
    });
};

// function update_obj(idtt) {
//     $.post("pages/thuoc-tinh/update.php", {
//         idtt: idtt,
//     }, function(data, status) {
//         $(".main-form").html(data);
//     });
// };

function delete_obj(idtt) {
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
            location.href = "pages/thuoc-tinh/action.php?req=delete&idtt=" + idtt;
        } else if (
            result.dismiss === Swal.DismissReason.cancel
        );
    });
};
window.addEventListener('load', function() {
    document.getElementById('dynamicTitle').innerText = "ADMIN | Quản lý thuộc tính";
})
</script>

<style>
/* CSS */
tr.sub td {
    text-indent: 50px;
    /* Điều chỉnh khoảng cách thục đầu dòng */
}
</style>