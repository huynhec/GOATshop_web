<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../model/UserModel.php';

$user = new UserModel();

if (isset($_GET['req'])) {
    switch ($_GET['req']) {
        case "add":
            $res = 0;
            $tenhienthi = $_POST['tenhienthi'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $phanquyen = $_POST['phanquyen'];
            $trangthai = $_POST['trangthai'];
            $res += $user->User__Add($tenhienthi, $username, $password, $phanquyen, $trangthai);
            if ($res != 0) {
                header('location: ../index.php?pages=tai-khoan&msg=success');
            } else {
                header('location: ../index.php?pages=tai-khoan&msg=error');
            }
            break;

        default:
            break;

        case "update":
            $res = 0;
            $mauser = $_POST['mauser'];
            $tenhienthi = $_POST['tenhienthi'];
            $username = $_POST['username'];
            $mat_khau_cu = $_POST['oldpassword'];
            $mat_khau_moi = $_POST['password'];
            $password = $mat_khau_cu;

            if ($mat_khau_moi != $mat_khau_cu && strlen($mat_khau_moi) > 0) {
                $password = $mat_khau_moi;
            }

            $phanquyen = $_POST['phanquyen'];
            $trangthai = $_POST['trangthai'];
            $res += $user->User__Update($tenhienthi, $username, $password, $phanquyen, $trangthai, $mauser);
            if ($res != 0) {
                header('location: ../index.php');
            } else {
                header('location: ../index.php');
                echo "Lỗi không sửa được!";
            }
            break;

        case "delete":
            $res = 0;
            $mauser = $_GET['mauser'];
            $res += $user->User__Delete($mauser);
            if ($res != 0) {
                header('location: ../index.php');
            } else {
                header('location: ../index.php');
                echo "Lỗi không xoá được!";

            }
            break;
    }
}
