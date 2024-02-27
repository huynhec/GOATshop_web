<?php
if (!isset($_SESSION['admin'])) {
    $msg = "Bạn không có quyền truy cập trang này!";
    header("location: ../auth/index.php?pages=trang-loi&error=$msg");
    exit();
}

require_once '../model/TrangThaiModel.php';
$tt = new TrangThaiModel();
$trangThai__Get_All = $tt->TrangThai__Get_All();
?>

<div id="main-container">
    <div class="main-title">
        <h3>Quản lý trạng thái</h3>
        <ul class="breadcrumb">
            <li>
                <a href="#">Quản lý trạng thái</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active" href="index.php?pages=loai-sp">Danh sách trạng thái</a>
            </li>
        </ul>
    </div>
    <div class="row section-container">
        <div class="col-8">
            <div class="main-data">
                <h3 class="section-title">Danh sách trạng thái</h3>
                <div class="table-responsive">
                    <table id="table_js" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên trạng thái</th>
                                <th>Mô tả</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($trangThai__Get_All as $item) : ?>
                                <tr>
                                    <td><?= $item->matt ?></td>
                                    <td><?= $item->tentt ?></td>
                                    <td><?= $item->mota ?></td>
                                    <td class="text-center font-weight-bold">
                                        <button type="button" class="btn btn-warning btn-update" onclick="return update_obj('<?= $item->matt ?>')">
                                            <i class="bx bx-edit" aria-hidden="true"></i> Sửa
                                        </button>
                                        <?php if (isset($_SESSION['admin'])) : ?>
                                            <button type="button" class="btn btn-danger btn-delete" onclick="return delete_obj('<?= $item->matt ?>')">
                                                <i class="bx bx-trash" aria-hidden="true"></i> Xóa
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
    function update_obj(matt) {
        $.post("pages/trang-thai/update.php", {
            matt: matt,
        }, function(data, status) {
            $(".main-form").html(data);
        });
    };

    function delete_obj(matt) {
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
                location.href = "pages/trang-thai/action.php?req=delete&matt=" + matt;
            } else if (
                result.dismiss === Swal.DismissReason.cancel
            );
        });
    };
    window.addEventListener('load', function() {
        document.getElementById('dynamicTitle').innerText = "ADMIN | Quản lý trạng thái";
    })
</script>