<?php
require_once '../../../model/NhanVienModel.php';
require_once '../../../model/UserModel.php';
require_once '../../../model/DiaChiModel.php';

$nv = new NhanVienModel();
$user = new UserModel();
$dc = new DiaChiModel();

if (isset($_GET['req'])) {
    switch ($_GET['req']) {
        case "add":
            $res = 0;
            $tenhienthi = $_POST['tennv'];
            $username = $_POST['username'];
            $gioitinh = $_POST['gioitinh'];
            $ngaysinh = $_POST['ngaysinh'];
            $sodienthoai = $_POST['sodienthoai'];
            $email = $_POST['email'];
            // Lấy thông tin địa chỉ
            $province_id = $_POST['tinh1_name'];
            $district_id = $_POST['huyen1_name'];
            $wards_id = $_POST['xa1'];
            $road = $_POST['road'];
            // $password = trim($_POST['password']);
            // $password = $_POST['password'];
            $password = $user->Ma_Hoa_Mat_Khau(trim($_POST['password']));
            $trangthai = $_POST['trangthai'];
            $phanquyen = $_POST['phanquyen'];
            if ($nv->NhanVien__Check_Email($email) && $user->User__Check_Username($username)) {
                $res += $nv->NhanVien__Add($tenhienthi, $gioitinh, $ngaysinh, $sodienthoai, $province_id, $district_id, $wards_id, $road, $email, $password, $username, $trangthai, $phanquyen);
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
            $gioitinh = $_POST['gioitinh'];
            $ngaysinh = $_POST['ngaysinh'];
            $sodienthoai = $_POST['sodienthoai'];
            $trangthai = $_POST['trangthai'];
            $phanquyen = $_POST['phanquyen'];

            $username_old = $_POST['username_old'];
            $username_new = $_POST['username_new'];
            $username = $username_old;


            if ($username_new != $username_old && strlen($username_new) > 0) {
                if ($user->User__Check_Username($username_new)) {
                    $username = $username_new;
                } else {
                    header('location: ../../index.php?pages=nhan-vien&msg=error');
                }
            }

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
                $password = $user->Ma_Hoa_Mat_Khau(trim($password_new));
            }

            echo $res += $nv->NhanVien__Update($manv, $tennv, $username, $gioitinh, $ngaysinh, $sodienthoai, $email, $password, $trangthai, $phanquyen);
            if ($res != false) {
                header('location: ../../index.php?pages=nhan-vien&msg=success');
            } else {
                header('location: ../../index.php?pages=nhan-vien&msg=error');
            }
            break;
        case "dia-chi":
            $res = 0;
            if (isset($_POST['diachi'])) {
                $diachi_parts = explode(', ', $_POST['diachi']);
                $tinh = $diachi_parts[0]; // "Hà Nội"
                $huyen = $diachi_parts[1]; // "Ba Đình"
                $xa = $diachi_parts[2]; // "Kim Mã"
                $road = $diachi_parts[3]; // "123 đường ABC"
                $manv = $_POST['manv'];

                $res += $dc->DiaChi_Nhanvien__Reset($manv, $tinh, $huyen, $xa, $road);
            }

            if ($res !== 0) {
                echo true;
            } else {
                echo false;
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
