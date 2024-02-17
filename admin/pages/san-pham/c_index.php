<?php
require_once '../model/AnhSpModel.php';
require_once '../model/SanPhamModel.php';
$anhSp = new AnhSpModel();
$sp = new SanPhamModel();
$masp = $_GET['masp'];
$sanPham__Get_By_Id = $sp->SanPham__Get_By_Id($masp);
$anhSp__Get_By_Id_Sp_First = $anhSp->AnhSp__Get_By_Id_Sp_First($masp);
$anhSp__Get_By_Id_Sp_Not_First = $anhSp->AnhSp__Get_By_Id_Sp_Not_First($masp);
?>

<div id="main-container">
    <div class="main-title">
        <h3>Quản lý sp nội dung</h3>
        <ul class="breadcrumb">
            <li>
                <a href="#">Quản lý sản phẩm</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active" href="index.php?pages=san-pham">Danh sách sản phẩm</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active" href="index.php?pages=anh-san-pham&masp=<?= $masp ?>">Danh sách
                    hình ảnh</a>
            </li>
        </ul>
    </div>
    <div class="row section-container">
        <div class="col-8">
            <div class="main-data">
                <h3 class="section-title">Danh sách hình ảnh sản phẩm: <b><?= $sanPham__Get_By_Id->tensp ?></b></h3>
                <div class="table-responsive">
                    <table id="table_js" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Hình ảnh</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><b>Ảnh giới thiệu</b></td>
                                <td><img src="../assets/<?= $anhSp__Get_By_Id_Sp_First->hinhanh ?>" alt="" class="img-fluid" width="100"></td>
                                <td class="text-center font-weight-bold">
                                    <button type="button" class="btn btn-warning btn-update" onclick="return update_obj('<?= $anhSp__Get_By_Id_Sp_First->maanh ?>')">
                                        <i class="bx bx-edit" aria-hidden="true"></i> Sửa
                                    </button>
                                    <?php if (isset($_SESSION['admin'])) : ?>
                                        <button type="button" class="btn btn-danger btn-delete" onclick="return delete_obj('<?= $anhSp__Get_By_Id_Sp_First->maanh ?>')">
                                            <i class="bx bx-trash" aria-hidden="true"></i> Xóa
                                        </button>
                                    <?php endif ?>
                                </td>
                            </tr>
                            <?php
                            $count = 0;
                            foreach ($anhSp__Get_By_Id_Sp_Not_First as $item) : ?>
                                <tr>
                                    <td><?= ++$count ?></td>
                                    <td><img src="../assets/<?= $item->hinhanh ?>" alt="<?= $item->maanh ?>" class="img-fluid" width="100"></td>
                                    <td class="text-center font-weight-bold">
                                        <button type="button" class="btn btn-warning btn-update" onclick="return update_obj('<?= $item->maanh ?>')">
                                            <i class="bx bx-edit" aria-hidden="true"></i> Sửa
                                        </button>
                                        <?php if (isset($_SESSION['admin'])) : ?>
                                            <button type="button" class="btn btn-danger btn-delete" onclick="return delete_obj('<?= $item->maanh ?>')">
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
                <?php require_once 'c_add.php' ?>
            </div>
        </div>
    </div>
</div>

<script>
    function update_obj(maanh) {
        $.post("pages/san-pham/c_update.php", {
            maanh: maanh,
        }, function(data, status) {
            $(".main-form").html(data);
        });
    };

    function add_obj() {
        $.post("pages/san-pham/c_add.php", {}, function(data, status) {
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
                location.href = "pages/san-pham/action.php?req=c_delete&maanh=" +
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