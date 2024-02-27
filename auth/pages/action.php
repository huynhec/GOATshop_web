<?php
session_start();
require_once '../../model/KhachHangModel.php';
require_once '../../model/NhanVienModel.php';
require_once '../../model/AdminModel.php';
require_once '../../model/UserModel.php';
$kh = new KhachHangModel();
$nhanVien = new NhanVienModel();
$admin = new AdminModel();
$user = new UserModel();

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
                if ($res->phanquyen == 1) {
                    $_SESSION['manager'] = $res;
                    header('location: ../../admin/');
                } elseif ($res->phanquyen == 2) {
                    $_SESSION['nhanvien'] = $res;
                    header('location: ../../admin/');
                } elseif ($resad->phanquyen == 0) {
                    $_SESSION['admin'] = $resad;
                    header('location: ../../admin');
                }
            }
            break;

        case "chinh-sua":
            $res = 0;
            $makh = $_POST['makh'];
            $tenkh = $_POST['tenkh'];
            $username = $_POST['username'];
            $gioitinh = $_POST['gioitinh'];
            $ngaysinh = $_POST['ngaysinh'];
            $sodienthoai = $_POST['sodienthoai'];
            $diachi = $_POST['diachi'];
            $trangthai = 1;


            // $email_old = trim($_POST['email_old']);
            // $email_new = trim($_POST['email_new']);
            $email_old = $_POST['email_old'];
            $email_new = $_POST['email_new'];

            $email = $email_old;

            if ($email_new != $email_old && strlen($email_new) > 0) {
                if ($kh->KhachHang__Check_Email($email_new)) {
                    $email = $email_new;
                } else {
                    header('location: ../../index.php?pages=khach-hang&msg=error');
                }
            }

            // $password_old = trim($_POST['password_old']);
            // $password_new = trim($_POST['password_new']);
            $password_old = $_POST['password_old'];
            $password_new = $_POST['password_new'];

            $password = $password_old;

            if ($password_new != $password_old && strlen($password_new) > 0) {
                $password = $password_new;
            }
            echo $res += $kh->KhachHang__Update($makh, $tenkh, $username, $gioitinh, $ngaysinh, $sodienthoai, $diachi, $email, $password, $trangthai);
            if ($res != 0) {
                unset($_SESSION['user']);
                header('location: ../index.php?pages=dang-nhap&msg=update-success');
            } else {
                header('location: ../index.php?pages=dang-nhap&msg=update-error');
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
            if (isset($_SESSION['nhanvien'])) {
                unset($_SESSION['nhanvien']);
            }
            header('location:' . $_SERVER["HTTP_REFERER"]);
            break;
        default:
            break;
    }
}
