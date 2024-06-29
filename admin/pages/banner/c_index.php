<?php
require_once '../model/BannerModel.php';

$bn = new BannerModel();
$id_banner = $_GET['id_banner'];
$banner__Get_By_Id = $bn->Banner__Get_By_Id($id_banner);
$anh_Banner__Get_By_Id_Sp_First = $bn->Anh_Banner__Get_By_Id_Sp_First($id_banner);

?>

<div id="main-container">
    <div class="main-title">
        <h3>Quản lý sp nội dung</h3>
        <ul class="breadcrumb">
            <li>
                <a href="#">Quản lý banner</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active" href="index.php?pages=banner">Danh sách banner</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active" href="index.php?pages=anh-banner&masp=<?= $id_banner ?>">Hình ảnh</a>
            </li>
        </ul>
    </div>
    <div class="row section-container">
        <div class="col-7">
            <div class="main-data">
                <h3 class="section-title">Hình ảnh Banner: <b><?= $banner__Get_By_Id->tenbanner ?></b></h3>
                <div class="table-responsive">
                    <table id="table_js" class="table table-striped" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Hình ảnh</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php $count = 0; ?>
                                <td><?= ++$count ?></td>
                                <td><img src="../assets/<?= $anh_Banner__Get_By_Id_Sp_First->anhbanner ?>" alt="<?= $anh_Banner__Get_By_Id_Sp_First->id_banner ?>" class="img-fluid" width="500"></td>
                                <td class="text-center font-weight-bold">
                                    <button type="button" class="btn btn-warning btn-update" onclick="return update_obj('<?= $anh_Banner__Get_By_Id_Sp_First->id_banner ?>')">
                                        <i class="bx bx-edit" aria-hidden="true"></i> Sửa
                                    </button>
                                    <?php if (isset($_SESSION['admin'])) : ?>
                                        <button type="button" class="btn btn-danger btn-delete" onclick="return delete_obj('<?= $anh_Banner__Get_By_Id_Sp_First->id_banner ?>')">
                                            <i class="bx bx-trash" aria-hidden="true"></i> Xóa
                                        </button>
                                    <?php endif ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="col-5">
            <div class="main-form">
            </div>
        </div>
    </div>
</div>

<script>
    function update_obj(id_banner) {
        $.post("pages/banner/c_update.php", {
            id_banner: id_banner,
        }, function(data, status) {
            $(".main-form").html(data);
        });
    };

    function delete_obj(maanh) {
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
                location.href = "pages/banner/action.php?req=c_delete&maanh=" +
                    maanh;
            } else if (
                result.dismiss === Swal.DismissReason.cancel
            );
        });
    };
    window.addEventListener('load', function() {
        document.getElementById('dynamicTitle').innerText = "ADMIN | Ảnh sản phẩm";
    })
</script>