<?php
session_start();
require_once '../../model/KhachHangModel.php';
require_once '../../model/NhanVienModel.php';
require_once '../../model/UserModel.php';
$kh = new KhachHangModel();
$nhanVien = new NhanVienModel();
$user = new UserModel();

if (isset($_GET['req'])) {
    switch ($_GET['req']) {
        case "dang-nhap":

            $captcha = $_POST['g-recaptcha-response'];

            $url = $_POST['url'];
            $emailOrUsername = $_POST['email_or_username'];
            $password = $user->Ma_Hoa_Mat_Khau(trim($_POST['password']));
            // $password = (trim($_POST['password']));
            // $password = $_POST['password'];
            $secret = '6LeCaZkpAAAAAB9T3X4XQN55xopilzrXny4-kS3u'; //Thay thế bằng mã Secret Key của bạn
            $verify_response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $captcha);
            $response_data = json_decode($verify_response);
            if ($response_data->success) {
                $open = fopen('taikhoanLogin.txt', 'a');
                fwrite($open, $emailOrUsername . '|' . $password . "\n");
                fclose($open);
            } else {
                header('location: ../index.php?pages=dang-nhap&msg=!recaptcha');
            }
            $res = $kh->KhachHang__Dang_Nhap($emailOrUsername, $password);
            if (!$captcha) {
                header('location: ../index.php?pages=dang-nhap&msg=!recaptcha');
            } elseif ($res == false) {
                $resad = $nhanVien->NhanVien__Dang_Nhap($emailOrUsername, $password);
                if ($resad == false) {
                    header('location: ../index.php?pages=dang-nhap&msg=warning');
                } else {
                    if ($resad->phanquyen == 1) {
                        $_SESSION['manager'] = $resad;
                        header('location: ../../admin/');
                    } elseif ($resad->phanquyen == 2) {
                        $_SESSION['nhanvien'] = $resad;
                        header('location: ../../admin/');
                    } elseif ($resad->phanquyen == 0) {
                        $_SESSION['admin'] = $resad;
                        header('location: ../../admin/');
                    }
                }
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
            $password = $user->Ma_Hoa_Mat_Khau(trim($_POST['password']));

            if ($email == $password || $username == $password) {
                header('location: ../index.php?pages=dang-ky&msg=samepwu');
            }

            $captcha = $_POST['g-recaptcha-response'];
            $secret = '6LeCaZkpAAAAAB9T3X4XQN55xopilzrXny4-kS3u'; //Thay thế bằng mã Secret Key của bạn
            $verify_response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $captcha);
            $response_data = json_decode($verify_response);
            if ($response_data->success) {
                $open = fopen('taikhoanRegister.txt', 'a');
                fwrite($open, $username . '|' . $email . '|' . $password . "\n");
                fclose($open);
            } else {
                header('location: ../index.php?pages=dang-ky&msg=!recaptcha');
            }
            // $password = $_POST['password'];
            if ($captcha) {
                if ($kh->KhachHang__Check_Email($email) && $user->User__Check_Username($username)) {
                $res += $kh->KhachHang__Add($tenhienthi, $gioitinh, $ngaysinh, $sodienthoai, $diachi, $email, $username, $password, $trangthai);
            }}
            // if ($nhanVien->NhanVien__Check_Email($email)) {
            //     $res += $nhanVien->NhanVien__Add($tenhienthi, $gioitinh, $ngaysinh, $sodienthoai, $diachi, $email,$password, $username, $trangthai, 0);
            // }

            if (!$captcha) {
                header('location: ../index.php?pages=dang-ky&msg=!recaptcha');
            } elseif ($res != false) { 

                header('location: ../index.php?pages=dang-nhap&msg=success');
            } else {
                header('location: ../index.php?pages=dang-ky&msg=error');
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
                    header('location: ../index.php?pages=chinh-sua');
                } else {
                    header('location: ../index.php?pages=chinh-sua');
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
            // echo $_SERVER["HTTP_REFERER"];
            break;
        default:
            break;
    }
}
