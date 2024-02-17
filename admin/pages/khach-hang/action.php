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
            // $password = trim($_POST['password']);
            $password = $_POST['password'];
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

        case "update":
            $res = 0;
            $makh = $_POST['makh'];
            $tenkh = $_POST['tenkh'];
            $username = $_POST['username'];
            $gioitinh = $_POST['gioitinh'];
            $ngaysinh = $_POST['ngaysinh'];
            $sodienthoai = $_POST['sodienthoai'];
            $diachi = $_POST['diachi'];
            $trangthai = $_POST['trangthai'];


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
