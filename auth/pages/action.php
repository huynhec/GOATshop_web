<?php
session_start();
require_once '../../model/KhachHangModel.php';
// require_once '../../model/NhanVienModel.php';
$kh = new KhachHangModel();
// $nhanVien = new NhanVienModel();

if (isset($_GET['req'])) {
    switch ($_GET['req']) {
        case "dang-nhap":
            $url = $_POST['url'];
            $emailOrUsername = $_POST['email_or_username'];
            // $password = $cm->MaHoaMatKhau(trim($_POST['password']));
            // $password = (trim($_POST['password']));
            $password = $_POST['password'];
            $res = $kh->KhachHang__Dang_Nhap($emailOrUsername, $password);
            if ($res == false) {
                header('location: ../index.php?pages=dang-nhap&msg=warning');
            } else {
                $_SESSION['user'] = $res;
                header('location:' . $url);
            }
            break;


        case "dang-ky":
            // Bật tất cả các báo cáo lỗi
            error_reporting(E_ALL);

            // Hiển thị lỗi ngay trên trang web
            ini_set('display_errors', 1);
            $res = 0;
            $tenhienthi = $_POST['tenkh'];
            $gioitinh = $_POST['gioitinh'];
            $ngaysinh = $_POST['ngaysinh'];
            $sodienthoai = $_POST['sodienthoai'];
            $diachi = $_POST['diachi'];
            $email = $_POST['email'];
            $username = $_POST['username'];
            $trangthai = 1;
            // $password = trim($_POST['password']);
            $password = $_POST['password'];
            if ($kh->KhachHang__Check_Email($email)) {
                $res += $kh->KhachHang__Add($tenhienthi, $gioitinh, $ngaysinh, $sodienthoai, $diachi, $email, $username, $password, $trangthai);
            }

            if ($res != false) {
                header('location: ../index.php?pages=dang-nhap');
            } else {
                header('location: ../index.php?pages=dang-ky&msg=error');
            }
            break;

        case "dang-xuat":
            if (isset($_SESSION['manager'])) {
                unset($_SESSION['manager']);
            }
            if (isset($_SESSION['admin'])) {
                unset($_SESSION['admin']);
            }
            if (isset($_SESSION['user'])) {
                unset($_SESSION['user']);
            }
            header('location:' . $_SERVER["HTTP_REFERER"]);
            break;
        default:
            break;
    }
}
