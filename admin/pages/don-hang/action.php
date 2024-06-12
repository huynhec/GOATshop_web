<?php
session_start();
require_once '../../../model/ChiTietTrangThaiModel.php';
require_once '../../../model/DonHangModel.php';
$cttt = new ChiTietTrangThaiModel();
$dh = new DonHangModel();
if (isset($_GET['req'])) {
    switch ($_GET['req']) {

        case "update":
            $res = 0;
            $madon = $_POST['madon'];
            $matt = $_POST['matt'];
            $manv = isset($_SESSION['admin']->manv) ? $_SESSION['admin']->manv : (isset($_SESSION['nhanvien']->manv) ? $_SESSION['nhanvien']->manv : $_SESSION['manager']->manv);
            $ngaytao = date('Y-m-d H:i:s');
            $res += $cttt->ChiTietTrangThai__Add($madon, $matt, $manv, $ngaytao);
            if ($matt = 1) {
                // cập nhật trạng thái đơn hàng
                $trangthai = 0;
                $dh->DonHang__Update_State($madon, $trangthai);
            }

            if ($res != 0) {
                header('location: ../../index.php?pages=don-hang&msg=success');
            } else {
                header('location: ../../index.php?pages=don-hang&msg=error');
            }
            break;
        default:
            break;
    }
}
