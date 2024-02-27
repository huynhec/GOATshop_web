<?php
require_once '../model/KhachHangModel.php';
$kh = new KhachHangModel();
$khachHang__Get_All = $kh->KhachHang__Get_All(-1);
?>

<div id="main-container">
    <div class="main-title">
        <h3>Quản lý khách hàng</h3>
        <ul class="breadcrumb">
            <li>
                <a href="#">Quản lý khách hàng</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active" href="index.php?pages=khach-hang">Danh sách khách hàng</a>
            </li>
        </ul>
    </div>
    <div class="row section-container">
        <div class="col-8">
            <div class="main-data">
                <h3 class="section-title">Danh sách khách hàng</h3>
                <div class="table-responsive">
                    <table id="table_js" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên khách hàng</th>
                                <th>Giới tính</th>
                                <th>Email</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($khachHang__Get_All as $item) : ?>
                                <tr>
                                    <td><?= $item->makh ?></td>
                                    <td><?= $item->tenkh ?></td>
                                    <td><?= $item->gioitinh == 1  ? 'Nữ'  : 'Nam' ?></td>
                                    <td><?= $item->email ?></td>
                                    <td><?= $item->trangthai == 1 ? '<span class="text-success">Hoạt động</span>' : '<span class="text-danger">Tạm khóa</span>' ?></td>
                                    <td class="text-center font-weight-bold">
                                        <button type="button" class="btn btn-warning btn-update" onclick="return update_obj('<?= $item->makh ?>')">
                                            <i class="bx bx-edit" aria-hidden="true"></i> Sửa
                                        </button>
                                        <?php if (isset($_SESSION['admin'])) : ?>
                                            <button type="button" class="btn btn-danger btn-delete" onclick="return delete_obj('<?= $item->makh ?>')">
                                                <i class="fa fa-trash" aria-hidden="true"></i> Xóa
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
        <div class="col-4">
            <div class="main-form">
                <?php require_once 'add.php' ?>
            </div>
        </div>
    </div>
</div>

<script>
    function update_obj(makh) {
        $.post("pages/khach-hang/update.php", {
            makh: makh,
        }, function(data, status) {
            $(".main-form").html(data);
        });
    };

    function delete_obj(makh) {
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
                location.href = "pages/khach-hang/action.php?req=delete&makh=" + makh;
            } else if (
                result.dismiss === Swal.DismissReason.cancel
            );
        });
    };
    window.addEventListener('load', function() {
        document.getElementById('dynamicTitle').innerText = "ADMIN | Quản lý khách hàng";
    })
</script>