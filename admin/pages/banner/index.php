<?php
require_once '../model/SanPhamModel.php';
require_once '../model/ThuongHieuModel.php';
require_once '../model/AnhSpModel.php';
require_once '../model/ThuocTinhModel.php';
require_once '../model/DonGiaModel.php';
require_once '../model/BannerModel.php';

$dg = new DonGiaModel();
$sp = new SanPhamModel();
$th = new ThuongHieuModel();
$anhSp = new AnhSpModel();
$tt = new ThuocTinhModel();
$bn = new BannerModel();
$sanPham__Get_All = $sp->SanPham__Get_All(-1);
$donGia__Get_All = $dg->DonGia__Get_All();
$banner_Get_All = $bn->banner__Get_All(-1);
?>

<div id="main-container">
    <div class="main-title">
        <h3>Quản lý banner</h3>
        <ul class="breadcrumb">
            <li>
                <a href="#">Quản lý banner</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active" href="index.php?pages=banner">Danh sách banner</a>
            </li>
        </ul>
    </div>
    <div class="row section-container">
        <div class="col-7">
            <div class="main-data">
                <h3 class="section-title">Danh sách banner</h3>
                <div class="table-responsive">
                    <table id="table_js" class="table table-striped" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Ảnh banner</th>
                                <th>Tên banner</th>
                                <th>Thao tác</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($banner_Get_All as $item) : ?>
                                <tr id="product_<?php echo $item->id_banner; ?>">
                                    <td><?= $item->id_banner ?></td>
                                    <td><img src="../assets/<?= $bn->Anh_Banner__Get_By_Id_Sp_First($item->id_banner)->anhbanner ?>" alt="" srcset="" class="img-fluid" width="350px"></td>
                                    <td><?= $item->tenbanner ?></td>
                                    <td><?= $item->trangthai == 1 ? '<span class="text-success">Hiển thị</span>' : '<span class="text-danger">Tạm ẩn</span>' ?>
                                    </td>
                                    <td class="text-center font-weight-bold">
                                        <button type="button" class="btn btn-primary btn-update" onclick="return update_anhsp_obj('<?= $item->id_banner ?>')">
                                            <i class="bx bx-photo-album" aria-hidden="true"></i>
                                        </button>
                                        <button type="button" class="btn btn-warning btn-update" onclick="return update_obj('<?= $item->id_banner ?>')">
                                            <i class="bx bx-edit" aria-hidden="true"></i>
                                        </button>
                                        <?php if (isset($_SESSION['admin'])) : ?>
                                            <button type="button" class="btn btn-danger btn-delete"
                                        onclick="return delete_obj('<?= $item->id_banner ?>')">
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
        <div class="col-4">
            <div class="treo">
                <div class="main-form">
                    <?php require_once 'add.php' ?>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    function update_anhsp_obj(id_banner) {
        location.href = "index.php?pages=anh-banner&id_banner=" + id_banner;
    };


    function update_obj(id_banner) {
        $.post("pages/banner/update.php", {
            id_banner: id_banner
        }, function(data, status) {
            $(".main-form").html(data);
        });
    };

    function delete_obj(id_banner) {
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
                location.href = "pages/banner/action.php?req=delete&id_banner=" + id_banner;
            } else if (
                result.dismiss === Swal.DismissReason.cancel
            );
        });
    };
    window.addEventListener('load', function() {
        document.getElementById('dynamicTitle').innerText = "ADMIN | Quản lý banner";
    })
</script>