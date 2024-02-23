<?php
require_once '../model/DonHangModel.php';
require_once '../model/SanPhamModel.php';
require_once '../model/NhanVienModel.php';
require_once '../model/KhachHangModel.php';
require_once '../model/TrangThaiModel.php';
require_once '../model/ChiTietTrangThaiModel.php';
require_once '../model/ChiTietDonHangModel.php';
require_once '../model/AnhSpModel.php';
require_once '../model/CommonModel.php';
$dh = new DonHangModel();
$kh = new KhachHangModel();
$sp = new SanPhamModel();
$nv = new NhanVienModel();
$tt = new TrangThaiModel();
$cttt = new ChiTietTrangThaiModel();
$ctdh = new ChiTietDonHangModel();
$anhSp = new AnhSpModel();
$cm = new CommonModel();

$makh = isset($_SESSION['user']->makh) ? $_SESSION['user']->makh : 0;
$donHang__Get_By_Id_Kh = $dh->DonHang__Get_By_Id_KH($makh);

$madon = isset($_POST['madon']) ? $_POST['madon'] : 0;
$chiTietDonHang__Get_By_Id_DH = $ctdh->ChiTietDonHang__Get_By_Id_DH($madon);
$chiTietTrangThai__Get_By_Id_DH = $cttt->ChiTietTrangThai__Get_By_Id_DH($madon);
?>


<main class="main">
    <div class="main-container">
        <section class="h-100 h-custom" style="background-color: #eee;">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col">
                        <div class="card">
                            <div class="card-body p-4">

                                <div class="row">
                                    <div class="col-lg-12">
                                        <h5 class="mb-3"><a href="?pages=trang-chu" class="text-body"><i class="bx bx-left-arrow-alt me-2"></i>Tiếp tục mua sắm</a></h5>
                                        <hr>

                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <div>
                                                <p class="mb-1">Đơn hàng của bạn</p>
                                                <p class="mb-0">Bạn có <?= count($donHang__Get_By_Id_Kh) ?> đơn hàng</p>
                                            </div>
                                        </div>

                                        <div class="card mb-3">
                                            <div class="card-body p-1">
                                                <div class="main-data">
                                                    <div class="table-responsive">
                                                        <table id="table_js" class="table table-striped" style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>ID</th>
                                                                    <th>Ngày đặt</th>
                                                                    <th>Số tiền</th>
                                                                    <th>Tình trạng</th>
                                                                    <th>Ngày cập nhật</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($donHang__Get_By_Id_Kh as $item) : ?>
                                                                    <tr>
                                                                        <td><?= $item->madon ?></td>
                                                                        <td><?= $item->ngaythem ?></td>
                                                                        <td><?= number_format($item->tongdh) ?>đ</td>
                                                                        <td><?= isset($cttt->ChiTietTrangThai__Get_Last_By_DH($item->madon)->tentt) ?  $cttt->ChiTietTrangThai__Get_Last_By_DH($item->madon)->tentt : 'Chưa xác nhận!' ?></td>
                                                                        <td><?= isset($cttt->ChiTietTrangThai__Get_Last_By_DH($item->madon)->ngaytao) ?  $cttt->ChiTietTrangThai__Get_Last_By_DH($item->madon)->ngaytao : 'Chưa xác nhận' ?></td>
                                                                        <td class="text-center font-weight-bold">
                                                                            <?php if (
                                                                                $cttt->ChiTietTrangThai__Check($item->madon, 1) != false // đơn bị từ chối bởi người bán
                                                                            ) : ?>
                                                                                <button type="button" class="btn btn-success btn-secondary" onclick="return view('<?= $item->madon ?>')">
                                                                                    <i class="bx bx-edit" aria-hidden="true"></i> Đơn đã hủy
                                                                                </button>

                                                                            <?php elseif ($cttt->ChiTietTrangThai__Check($item->madon, 6) != false) :   // đơn được giao thành công)
                                                                            ?>

                                                                                <button type="button" class="btn btn-sm btn-success btn-update" onclick="return view('<?= $item->madon ?>')">
                                                                                    <i class="bx bxs-happy-heart-eyes" aria-hidden="true"></i> Đơn đã giao
                                                                                </button>
                                                                            <?php else : ?>
                                                                                <?php if (!isset($cttt->ChiTietTrangThai__Get_Last_By_DH($item->madon)->tentt)) : ?>
                                                                                    <button type="button" class="btn btn-sm btn-danger btn-update" onclick="return remove('<?= $item->madon ?>')">
                                                                                        <i class="bx bxs-edit" aria-hidden="true"></i> Hủy đơn
                                                                                    </button>
                                                                                    
                                                                                <button type="button" class="btn btn-sm btn-primary btn-update" onclick="return view('<?= $item->madon ?>')">
                                                                                <i class="bx bxs-happy-heart-eyes" aria-hidden="true"></i> Xem
                                                                                <?php endif ?>
                                                                            <?php endif ?>
                                                                        </td>

                                                                        <td class="text-center font-weight-bold">

                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
</main>

<script>
    function view(madon) {
        $.ajax({
            url: './pages/don-hang/view.php',
            type: 'POST',
            data: {
                madon: madon
            },
            success: function(response) {
                Swal.fire({
                    title: "Chi tiết đơn hàng",
                    showCloseButton: true,
                    html: response
                });
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    function remove(madon) {
        Swal.fire({
            icon: 'question',
            title: "Xác nhận",
            text: "Bạn chắc chắn hủy đơn này?",
            showCancelButton: true,
            confirmButtonText: "OK",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "./components/action.php",
                    data: {
                        action: "delete",
                        madon: madon
                    },
                    success: function(response) {
                        console.log(response);
                        if (response == true) {
                            Swal.fire({
                                icon: "success",
                                title: "Đã xóa đơn thành công!",
                                confirmButtonText: "OK",
                            }).then((result) => {});
                            location.href = "?pages=don-hang";
                        }
                    },
                });
            }
        });
    }
</script>