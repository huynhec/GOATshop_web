<?php
session_start();
require_once '../../model/KhachHangModel.php';
require_once '../../model/NhanVienModel.php';
require_once '../../model/AdminModel.php';
$kh = new KhachHangModel();
$nhanVien = new NhanVienModel();
$admin = new AdminModel();

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

        case "dang-nhap-admin":
            $emailOrUsername = $_POST['email_or_username'];
            // $password = $cm->MaHoaMatKhau(trim($_POST['password']));
            // $password = (trim($_POST['password']));
            $password = $_POST['password'];

            $res = $nhanVien->NhanVien__Dang_Nhap($emailOrUsername, $password);
            $resad = $admin->Admin__Dang_Nhap($emailOrUsername, $password);
            if ($res == false && $resad == false) {
                header('location: ../index.php?pages=dang-nhap-admin&msg=warning');
            } else {
                if ($res->phanquyen == 0 ) {
                    $_SESSION['admin'] = $res;
                    header('location: ../../admin/');
                } elseif ($res->phanquyen == 1) {
                    $_SESSION['manager'] = $res;
                    header('location: ../../admin/');
                } elseif ($res->phanquyen == 2) {
                    $_SESSION['nhanvien'] = $res;
                    header('location: ../../admin/');
                } elseif ($resad->phanquyen == 0){
                    $_SESSION['admin'] = $resad;
                    header('location: ../../admin');
                }
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
            if (isset($_SESSION['nhanvien'])){
                unset($_SESSION['nhanvien']);
            }
            header('location:' . $_SERVER["HTTP_REFERER"]);
            break;
        default:
            break;
    }
}
