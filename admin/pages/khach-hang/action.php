<?php
require_once '../../../model/KhachHangModel.php';
$kh = new KhachHangModel();

if (isset($_GET['req'])) {
    switch ($_GET['req']) {
        case "add":
            $res = 0;
            $tenkh = $_POST['tenkh'];
            $gioitinh = $_POST['gioitinh'];
            $ngaysinh = $_POST['ngaysinh'];
            $sodienthoai = $_POST['sodienthoai'];
            $diachi = $_POST['diachi'];
            $email = $_POST['email'];
            $username = $_POST['username'];
            $password = trim($_POST['password']);
            $trangthai = $_POST['trangthai'];
            if ($kh->KhachHang__Check_Email($email)) {
                $res += $kh->KhachHang__Add($tenkh, $gioitinh, $ngaysinh, $sodienthoai, $diachi, $email, $username, $password, $trangthai);
            }
            if ($res != false) {
                header('location: ../../index.php?pages=khach-hang&msg=success');
            } else {
                header('location: ../../index.php?pages=khach-hang&msg=error');
            }
            break;
        default:
            break;
    }
}
