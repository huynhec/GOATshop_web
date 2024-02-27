<?php
require_once '../model/DonHangModel.php';
require_once '../model/NhanVienModel.php';
require_once '../model/KhachHangModel.php';
require_once '../model/TrangThaiModel.php';
require_once '../model/ChiTietTrangThaiModel.php';
require_once '../model/ChiTietDonHangModel.php';
$dh = new DonHangModel();
$kh = new KhachHangModel();
$nv = new NhanVienModel();
$tt = new TrangThaiModel();
$cttt = new ChiTietTrangThaiModel();
$ctdh = new ChiTietDonHangModel();
$donHang__Get_All = $dh->DonHang__Get_All();
?>

<div id="main-container">
    <div class="main-title">
        <h3>Quản lý đơn hàng</h3>
        <ul class="breadcrumb">
            <li>
                <a href="#">Quản lý đơn hàng</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active" href="index.php?pages=don-hang">Danh sách đơn hàng</a>
            </li>
        </ul>
    </div>
    <div class="row section-container">
        <div class="col-8">
            <div class="main-data">
                <h3 class="section-title">Danh sách đơn hàng</h3>
                <div class="table-responsive">
                    <table id="table_js" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Ngày đặt</th>
                                <th>Khách hàng</th>
                                <th>Số tiền</th>
                                <th>Tình trạng</th>
                                <th>Ngày cập nhật</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($donHang__Get_All as $item) : ?>
                                <tr>
                                    <td><?= $item->madon ?></td>
                                    <td><?= $item->ngaythem ?></td>
                                    <td><?= $kh->KhachHang__Get_By_Id($item->makh)->tenkh ?></td>
                                    <td><?= number_format($item->tongdh) ?></td>
                                    <td><?= isset($cttt->ChiTietTrangThai__Get_Last_By_DH($item->madon)->tentt) ?  $cttt->ChiTietTrangThai__Get_Last_By_DH($item->madon)->tentt : 'Chưa xác nhận!' ?></td>
                                    <td><?= isset($cttt->ChiTietTrangThai__Get_Last_By_DH($item->madon)->ngaytao) ?  $cttt->ChiTietTrangThai__Get_Last_By_DH($item->madon)->ngaytao : 'Chưa xác nhận' ?></td>
                                    <?php if (isset($_SESSION['admin'])) : ?>
                                        <td class="text-center font-weight-bold">
                                        <?php if (
                                                $cttt->ChiTietTrangThai__Check($item->madon, 1) != false // đơn bị hủy bởi người bán
                                            ) : ?>
                                                <button type="button" class="btn btn-success btn-secondary" onclick="handleUpdate()">
                                                    <i class="bx bx-edit" aria-hidden="true"></i> Đơn đã hủy
                                                </button>

                                            <?php elseif ($cttt->ChiTietTrangThai__Check($item->madon, 6) != false) :   // đơn được giao thành công)
                                            ?>
                                                <button type="button" class="btn btn-success btn-update" onclick="handleUpdate()">
                                                    <i class="bx bx-edit" aria-hidden="true"></i> Đơn đã giao
                                                </button>
                                            <?php else : ?>
                                                <button type="button" class="btn btn-danger btn-update" onclick="handleUpdate()">
                                                    <i class="bx bx-edit" aria-hidden="true"></i> Đơn cần xử lý
                                                </button>
                                            <?php endif ?>
                                        </td>
                                    <?php else : ?>
                                        <td class="text-center font-weight-bold">
                                            <?php if (
                                                $cttt->ChiTietTrangThai__Check($item->madon, 1) != false // đơn bị hủy bởi người bán
                                            ) : ?>
                                                <button type="button" class="btn btn-success btn-secondary" onclick="return update_obj('<?= $item->madon ?>')">
                                                    <i class="bx bx-edit" aria-hidden="true"></i> Đơn đã hủy
                                                </button>

                                            <?php elseif ($cttt->ChiTietTrangThai__Check($item->madon, 6) != false) :   // đơn được giao thành công)
                                            ?>
                                                <button type="button" class="btn btn-success btn-update" onclick="return update_obj('<?= $item->madon ?>')">
                                                    <i class="bx bx-edit" aria-hidden="true"></i> Đơn đã giao
                                                </button>
                                            <?php else : ?>
                                                <button type="button" class="btn btn-danger btn-update" onclick="return update_obj('<?= $item->madon ?>')">
                                                    <i class="bx bx-edit" aria-hidden="true"></i> Đơn cần xử lý
                                                </button>
                                            <?php endif ?>
                                        </td>
                                    <?php endif ?>
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
     function handleUpdate() {
        Swal.fire({
            title: 'Thông báo',
            text: 'Chỉ quản lý và nhân viên mới thao tác được',
            icon: 'info',
        });
    }
    
    function update_obj(madon) {
        $.post("pages/don-hang/update.php", {
            madon: madon,
        }, function(data, status) {
            $(".main-form").html(data);
        });
    };

    function delete_obj(madon) {
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
                location.href = "pages/don-hang/action.php?req=delete&madon=" + madon;
            } else if (
                result.dismiss === Swal.DismissReason.cancel
            );
        });
    };
    window.addEventListener('load', function() {
        document.getElementById('dynamicTitle').innerText = "ADMIN | Quản lý đơn hàng";
    })
</script>