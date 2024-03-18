<?php
require_once '../../../model/DonHangModel.php';
require_once '../../../model/SanPhamModel.php';
require_once '../../../model/NhanVienModel.php';
require_once '../../../model/KhachHangModel.php';
require_once '../../../model/TrangThaiModel.php';
require_once '../../../model/ChiTietTrangThaiModel.php';
require_once '../../../model/ChiTietDonHangModel.php';
require_once '../../../model/SizeSpModel.php';
$dh = new DonHangModel();
$kh = new KhachHangModel();
$sp = new SanPhamModel();
$nv = new NhanVienModel();
$tt = new TrangThaiModel();
$cttt = new ChiTietTrangThaiModel();
$ctdh = new ChiTietDonHangModel();
$szsp = new SizeSpModel();

$madon = $_POST['madon'];
$chiTietDonHang__Get_By_Id_DH = $ctdh->ChiTietDonHang__Get_By_Id_DH($madon);
$chiTietTrangThai__Get_By_Id_DH = $cttt->ChiTietTrangThai__Get_By_Id_DH($madon);
$trangThai__Get_BY_Id_DH = $tt->TrangThai__Get_By_Id_DH($madon);

?>

<div class="main-update">
    <h3 class="section-title">Chi tiết đơn hàng</h3>

    <div class="table-responsive">
        <table id="table_js" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Size</th>
                    <th>Đơn giá</th>
                    <th>Tổng cộng</th>
                </tr>
            </thead>
            <tbody>
                <?php $count = 0;
                foreach ($chiTietDonHang__Get_By_Id_DH as $item) : ?>
                    <tr>
                        <td><?= ++$count ?></td>
                        <td><?= $sp->SanPham__Get_By_Id($item->masp)->tensp ?></td>
                        <td><?= $item->soluong ?></td>
                        <td><?= $szsp->SizeSp__Get_By_Id($item->masize)->tensize ?></td>
                        <td><?= number_format($item->dongia) ?></td>
                        <td><?= number_format($item->tongcong) ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
            <tfoot>
                <tr class="text-center">
                    <th colspan="3">Tổng số tiền:</th>
                    <th colspan="2"><?= number_format($ctdh->ChiTietDonHang__Sum_Tien_DH($item->madon)->sum_tien) ?></th>
                </tr>
            </tfoot>
        </table>
    </div>
    <hr>
    <h4 class="section-title">Trạng thái đơn hàng</h4>

    <div class="table-responsive">
        <table id="table_js" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                </tr>
            </thead>
            <tbody>
                <?php $count = 0;
                foreach ($chiTietTrangThai__Get_By_Id_DH as $item) : ?>
                    <tr>
                        <td><?= ++$count ?></td>
                        <td><?= $tt->TrangThai__Get_By_Id($item->matt)->tentt ?></td>
                        <td><?= $item->ngaytao ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
    <form class="form-group" action="pages/don-hang/action.php?req=update" method="post">
        <input type="hidden" value="<?= $item->madon ?>" name="madon" required>
        <div class="col">
            <label>Cập nhật tình trạng đơn:</label>

            <?php
            $lastMATT = isset($cttt->ChiTietTrangThai__Get_Last_By_DH($madon)->matt) ? $cttt->ChiTietTrangThai__Get_Last_By_DH($madon)->matt : null;

            if (($lastMATT == 1) || ($lastMATT == 6)) :
            ?>
                <label class="form-check-label" for="matt<?= $item->matt ?>">...</label>
            <?php else : ?>

                <?php foreach ($trangThai__Get_BY_Id_DH as $item) : ?>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input checkbox" type="radio" id="matt<?= $item->matt ?>" value="<?= $item->matt ?>" name="matt" required <?= (isset($cttt->ChiTietTrangThai__Get_Last_By_DH($madon)->matt) ? $cttt->ChiTietTrangThai__Get_Last_By_DH($madon)->matt : "") == $item->matt ? 'checked' : '' ?>>
                        <label class="form-check-label" for="matt<?= $item->matt ?>"><?= $item->tentt ?></label>
                    </div>
                <?php endforeach; ?>
                <div class="col text-center">
                    <button type="submit" class="btn btn-primary">Lưu thông tin</button>
                </div>
            <?php endif; ?>

        </div>
        <br />

    </form>

</div>