<?php
require_once '../../../model/NhanVienModel.php';
$nv = new NhanVienModel();

if (isset($_GET['req'])) {
    switch ($_GET['req']) {
        case "add":
            $res = 0;
            $tenhienthi = $_POST['tennv'];
            $username = $_POST['username'];
            $gioitinh = $_POST['gioitinh'];
            $ngaysinh = $_POST['ngaysinh'];
            $sodienthoai = $_POST['sodienthoai'];
            $diachi = $_POST['diachi'];
            $email = $_POST['email'];
            // $password = trim($_POST['password']);
            $password = $_POST['password'];
            $trangthai = $_POST['trangthai'];
            $phanquyen = $_POST['phanquyen'];
            if ($nv->NhanVien__Check_Email($email)) {
                $res += $nv->NhanVien__Add($tenhienthi, $gioitinh, $ngaysinh, $sodienthoai, $diachi, $email, $password, $username, $trangthai, $phanquyen);
            }
            if ($res != false) {
                header('location: ../../index.php?pages=nhan-vien&msg=success');
            } else {
                header('location: ../../index.php?pages=nhan-vien&msg=error');
            }
            break;

        case "update":
            $res = 0;
            $manv = $_POST['manv'];
            $tennv = $_POST['tennv'];
            $username = $_POST['username'];
            $gioitinh = $_POST['gioitinh'];
            $ngaysinh = $_POST['ngaysinh'];
            $sodienthoai = $_POST['sodienthoai'];
            $diachi = $_POST['diachi'];
            $trangthai = $_POST['trangthai'];
            $phanquyen = $_POST['phanquyen'];


            // $email_old = trim($_POST['email_old']);
            // $email_new = trim($_POST['email_new']);
            $email_old = $_POST['email_old'];
            $email_new = $_POST['email_new'];
            $email = $email_old;


            if ($email_new != $email_old && strlen($email_new) > 0) {
                if ($nv->NhanVien__Check_Email($email_new)) {
                    $email = $email_new;
                } else {
                    header('location: ../../index.php?pages=nhan-vien&msg=error');
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

            echo $res += $nv->NhanVien__Update($manv, $tennv, $username, $gioitinh, $ngaysinh, $sodienthoai, $diachi, $email, $password, $trangthai, $phanquyen);
            if ($res != false) {
                header('location: ../../index.php?pages=nhan-vien&msg=success');
            } else {
                header('location: ../../index.php?pages=nhan-vien&msg=error');
            }
            break;
            
        case "delete":
            $res = 0;
            $manv = $_GET['manv'];
            $res += $nv->NhanVien__Delete($manv);
            if ($res != 0) {
                header('location: ../../index.php?pages=nhan-vien&msg=success');
            } else {
                header('location: ../../index.php?pages=nhan-vien&msg=error');
            }
            break;
        default:
            break;
    }
}
