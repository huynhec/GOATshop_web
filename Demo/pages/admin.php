<?php
require '../model/model.php';
$taikhoan = new Model();
$taikhoan__Get_All = $taikhoan->TaiKhoan__Get_All();
?>
<button onclick="logout()" class="btn btn-sm btn-primary" value="logout" name="logout">Đăng xuất</button>
<div class="container">
    <div class="row">
        <div class="col-8">
            <h3 class="section-title">Danh sách tài khoản</h3>
            <div class="table-responsive">
                <table id="table_js" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên hiển thị</th>
                            <th>Tên tài khoản</th>
                            <th>Password</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($taikhoan__Get_All as $item): ?>
                            <tr>
                                <td><?= $item->mauser ?></td>
                                <td><?= $item->username ?></td>
                                <td><?= $item->tenhienthi ?></td>
                                <td><?= $item->password ?></td>
                                <td><?= $item->trangthai ?></td>
                                <td>
                                    <button class="btn btn-sm btn-primary"
                                        onclick="update_obj(<?= $item->mauser ?>)">Sửa</button>
                                    <button class="btn btn-sm btn-danger"
                                        onclick="delete_obj(<?= $item->mauser ?>)">Xóa</button>
                                </td>
                            </tr>
                        <?php endforeach ?>

                    </tbody>
                </table>
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
    function logout() {
        header("Location: ../pages/login.php");
        exit;
    }


    function update_obj(tai_khoan_id) {
        $.post("update.php", {
            tai_khoan_id: tai_khoan_id,
        }, function (data, status) {
            $(".main-form").html(data);
        });
    };

    function add_obj() {
        $.post("add.php", {}, function (data, status) {
            $(".main-form").html(data);
        });
    };

    function delete_obj(tai_khoan_id) {
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
                location.href = "action.php?req=delete&tai_khoan_id=" + tai_khoan_id;
            } else if (
                result.dismiss === Swal.DismissReason.cancel
            );
        });
    };
    window.addEventListener('load', function () {
        document.getElementById('dynamicTitle').innerText = "ADMIN | Quản lý tài khoản";
    })
</script>