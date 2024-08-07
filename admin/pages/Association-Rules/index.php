<?php
require_once '../model/ImportModel.php';
require_once '../model/SanPhamModel.php';
require_once '../model/AnhSpModel.php';
$import = new ImportModel();
$anhSp = new AnhSpModel();
$sp = new SanPhamModel();

$import__Get_All = $import->import__Get_All();
?>

<div id="main-container">
    <div class="main-title">
        <h3>Quản lý import</h3>
        <ul class="breadcrumb">
            <li>
                <a href="#">Quản lý import</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active" href="index.php?pages=loai-sp">Danh sách import</a>
            </li>
        </ul>
    </div>
    <div class="row section-container">

        <div class="col-8">
            <div class="main-data">
                <a href="pages/Association-Rules/action.php?req=export" class="btn btn-danger float-right">EXPORT</a>
                <a onclick="training_model()" class="btn btn-primary float-right">TRAINING</a>


                <h3 class="section-title">Danh sách import</h3>
                <div class="table-responsive">
                    <table id="table_js" class="table table-striped" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Sản phẩm</th>
                                <th>Sản phẩm gợi ý</th>
                                <th>Support</th>
                                <th>Confidence</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $num = 0; ?>
                            <?php foreach ($import__Get_All as $item) : ?>
                            <tr>
                                <td><?= $item->id ?></td>
                                <td><img style="cursor:pointer; " src="../assets/<?= $anhSp->AnhSp__Get_By_Id_Sp_First($item->masp)->hinhanh ?>" alt="" srcset="" class="img-fluid" width="50"></td>
                                <td><img style="cursor:pointer; " src="../assets/<?= $anhSp->AnhSp__Get_By_Id_Sp_First($item->masp_rec)->hinhanh ?>" alt="" srcset="" class="img-fluid" width="50"></td>
                                <td><?= $item->sup ?>%</td>
                                <td><?= $item->conf ?>%</td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                    </< </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="main-form">
                <form class="row form" action="pages/Association-Rules/action.php?req=import" method="post"
                    enctype="multipart/form-data">
                    <div class="col-12">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Import</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        title="Collapse">
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
</div>


<!-- /.content-wrapper -->


<script>
window.addEventListener("load", function() {
    $("#tablejs").DataTable({
        "responsive": true,
        "autoWidth": false,
        // "buttons": ["copy", "csv", "excel", "pdf", "print"]
    }).buttons().container().appendTo('#tablejs_wrapper .col-md-6:eq(0)');
});


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
                    $.get("pages/Association-Rules/action.php?req=training", {}, function(data, status) {
                        if (data && !data.includes("failed")) {
                            console.log("Tệp đã được tạo thành công. Đường dẫn: " + data);
                            window.location = '?pages=Association-Rules&msg=success'
                        } else {
                            console.log("Lỗi: " + data);
                            window.location = '?pages=Association-Rules&msg=fail'
                        }
                    });
                },
                willClose: () => {}
            }).then((result) => {
                console.log('Results: ' + result);
            });

        }
</script>