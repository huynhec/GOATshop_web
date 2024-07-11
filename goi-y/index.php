<?php
require_once '../model/GoiYModel.php';
require_once '../model/KhachHangModel.php';
require_once '../model/SanPhamModel.php';
require_once '../model/ThuongHieuModel.php';
require_once '../model/AnhSpModel.php';
require_once '../model/DongiaModel.php';
$goiY = new GoiYModel();
$kh = new KhachHangModel();
$sp = new SanPhamModel();
$th = new ThuongHieuModel();
$anhSp = new AnhSpModel();
$dg = new DongiaModel();
$goiY__Get_All = $goiY->goiY__Get_All();
?>

<div id="main-container">
    <div class="main-title">
        <h3>Quản lý gợi ý</h3>
        <ul class="breadcrumb">
            <li>
                <a href="#">Quản lý gợi ý</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active" href="index.php?pages=goi-y">Danh sách gợi ý</a>
            </li>
        </ul>
    </div>
    <div class="row section-container">
        <div class="col-12">
            <div class="main-data">
                <h3 class="section-title">Danh sách gợi ý</h3>
                <div class="form-group">
                    <!-- <a href="pages/goi-y/action.php?req=training" class="btn btn-sm btn-danger">Huấn luyện</a> -->
                    <!-- <a href="pages/goi-y/action.php?req=training" class="btn btn-sm btn-danger">Huấn luyện</a> -->
                    <a onclick="training_model()" class="btn btn-danger float-right">Huấn luyện</a>

                </div>
                <div class="table-responsive">
                    <table id="table_js" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <!-- <th>ID</th> -->
                                <th>Khách hàng</th>
                                <th>Ảnh sản phẩm</th>
                                <th>Tên sản phẩm</th>
                                <!-- <th>Đơn giá</th> -->
                                <th>Rank</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($goiY__Get_All as $item) : ?>
                                <tr>
                                    <!-- <td><?= $item->idgoiy ?></td> -->
                                    <td><?= $kh->KhachHang__Get_By_Id($item->khachhang)->tenkh ?></td>
                                    <td><img src="../assets/<?= $anhSp->AnhSp__Get_By_Id_Sp_First($item->idsp)->hinhanh ?>" alt="" srcset="" class="img-fluid" width="50"></td>
                                    <td>
                                        <p class="text_over"><?= $item->tensp ?></p>
                                    </td>
                                    <!-- <td><?= number_format($dg->Dongia__Get_By_Id_Sp_First($item->idsp)->dongia) ?></td> -->
                                    <td><?= $item->rank ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    function training_model() {
        Swal.fire({
            title: "Đang thực thi!!",
            html: "Vui lòng không đóng cửa sổ này!!!",
            timerProgressBar: true,
            showCancelButton: false,
            allowOutsideClick: false,
            showCloseButton: false,
            didOpen: () => {
                Swal.showLoading();
                $.get("pages/goi-y/action.php?req=training", {}, function(data, status) {
                    if (data && !data.includes("failed")) {
                        console.log("Tệp đã được tạo thành công. Đường dẫn: " + data);
                        window.location = '?pages=User-Based&msg=success'
                    } else {
                        console.log("Lỗi: " + data);
                        window.location = '?pages=goi-y&msg=fail'
                    }
                });
            },
            willClose: () => {}
        }).then((result) => {
            console.log('Results: ' + result);
        });

    }
</script>