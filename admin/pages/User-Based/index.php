<?php
require_once '../model/SanPhamModel.php';
require_once '../model/AnhSpModel.php';
require_once '../model/GoiYModel.php';

$sp = new SanPhamModel();
$anhSp = new AnhSpModel();
$gy = new GoiYModel();

$goiy_user_based__Get_All = $gy->Goi_Y_User_Based__Get_All();

?>

<div id="main-container">
    <div class="main-title">
        <h3>Huấn luyện mô hình User Based</h3>
        <ul class="breadcrumb">
            <li>
                <a href="#">Huấn luyện mô hình User Based</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active" href="index.php?pages=User-Based">Mô hình User Based</a>
            </li>
        </ul>
    </div>
    <div class="row section-container">
        <div class="col-7">
            <div class="main-data">
                <a href="pages/User-Based/action.php?req=export" class="btn btn-danger float-right">EXPORT</a>
                <a onclick="training_model()" class="btn btn-primary float-right">TRAINING</a>

                <h3 class="section-title">Mô hình User Based</h3>
                <div class="table-responsive">
                    <table id="table_js" class="table table-striped" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Mã khách hàng</th>
                                <th>Ảnh sản phẩm</th>
                                <th>Tên sản phẩm</th>
                                <th>Rank</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($goiy_user_based__Get_All as $key => $box) : ?>
                                <input type="hidden" id="masp_1" value="<?= $key == 0 ? $box->item : 0 ?>">
                                <tr>
                                    <td><?= $box->id ?></td>
                                    <td><?= $box->user ?></td>
                                    <td><img style="cursor:pointer; " src="../assets/<?= $anhSp->AnhSp__Get_By_Id_Sp_First($box->item)->hinhanh ?>" alt="" srcset="" class="img-fluid" width="50"></td>
                                    <td>
                                        <span data-toggle="tooltip" title="<?= $sp->SanPham__Get_By_Id($box->item)->tensp ?>">
                                            <?= strlen($sp->SanPham__Get_By_Id($box->item)->tensp) > 60 ? substr($sp->SanPham__Get_By_Id($box->item)->tensp, 0, 60) . '...' : $sp->SanPham__Get_By_Id($box->item)->tensp ?>
                                        </span>
                                    </td>
                                    <td><?= $box->rank ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="main-form">
                <form class="row form" action="pages/User-Based/action.php?req=import" method="post" enctype="multipart/form-data">
                    <div class="col-12">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Import</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">Chọn file import <span class="color-crimson">(*)</span></label>
                                    <input type="file" id="file" name="file" class="form-control" required>

                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <input type="submit" value="Import" class="btn btn-success float-right">
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </form>
            </div>
        </div>

    </div>




    <script>
        window.addEventListener('load', function() {
            document.getElementById('dynamicTitle').innerText = "ADMIN | Quản lý thời gian theo dõi";
            masp_1 = document.getElementById('masp_1').value;
            trackingitem_chart(masp_1)
        })



        function trackingitem_chart(masp) {
            $.post("pages/User-Based/trackingitem_chart.php", {
                masp: masp,
            }, function(data, status) {
                $(".main-form").html(data);
            });
        };


        /* -------------------------------------------------------------------------- */
        /*                               training_model                               */
        /* -------------------------------------------------------------------------- */
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
                    $.get("pages/User-Based/action.php?req=training", {}, function(data, status) {
                        if (data && !data.includes("failed")) {
                            console.log("Tệp đã được tạo thành công. Đường dẫn: " + data);
                            window.location = '?pages=User-Based&msg=success'
                        } else {
                            console.log("Lỗi: " + data);
                            window.location = '?pages=User-Based&msg=fail'
                        }
                    });
                },
                willClose: () => {}
            }).then((result) => {
                console.log('Results: ' + result);
            });

        }
    </script>