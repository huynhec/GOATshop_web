<!-- <?php
session_start();
if (!isset($_SESSION['user'])) {
    header("location: ../../auth/?pages=dang-nhap");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="dynamicTitle">GOATshop</title>
</head>

<link rel="shortcut icon" href="../assets/images/logo-no-background.ico" type="image/x-icon">
<link rel="stylesheet" href="../../assets/vendor/bootstrap-5.2.3-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../../assets/css/auth.css">
</head>

<body>
    <div class="login-register-container">
        <div class="auth-container">
            <div class="logo-wrapper">
                <img src="../../assets/images/loginadmin.jpeg" alt="login" class="img-fluid">
            </div>
            <div class=" form-wrapper">
                <img src="../../assets/images/logo-no-background.png" alt="logo" class="img-fluid">
                <h3 class="text-title mb-5">Chỉnh sửa thông tin</h3>
                <form class="form-group" action="action.php?req=chinh-sua" method="post">
                    <input type="hidden" class="form-control" id="makh" name="makh" required value="<?= $_SESSION['user']->makh ?>">
                    <input type="hidden" class="form-control" id="password_old" name="password_old" value="<?= $_SESSION['user']->password ?>">
                    <input type="hidden" class="form-control" id="email_old" name="email_old" required value="<?= $_SESSION['user']->email ?>">


                    <div class="col">
                        <label for="tenkh" class="form-label">Tên hiển thị</label>
                        <input type="text" class="form-control" id="tenkh" name="tenkh" required value="<?= $_SESSION['user']->tenkh ?>">
                        <label for="tennv" class="form-label">Tên đăng nhập</label>
                        <?php
                        $username = isset($_SESSION['user']->username) ? $_SESSION['user']->username : '';
                        ?>
                        <input type="text" class="form-control" id="username" name="username" required value="<?= $_SESSION['user']->username ?? '' ?>">
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="ngaysinh" class="form-label">Ngày sinh</label>
                            <input type="date" min="<?= date('Y-m-d', strtotime('-100 years')) ?>" max="<?= date('Y-m-d', strtotime('-18 years')) ?>" class="form-control" id="ngaysinh" name="ngaysinh" required value="<?= $_SESSION['user']->ngaysinh ?>">
                        </div>
                        <div class="col">
                            <label for="gioitinh" class="form-label">Giới tính</label>
                            <select class="form-select " aria-label=".gioitinh" id="gioitinh" name="gioitinh">
                                <option value="0" <?= $_SESSION['user']->gioitinh == 0 ? 'selected' : '' ?>>Nam</option>
                                <option value="1" <?= $_SESSION['user']->gioitinh == 1 ? 'selected' : '' ?>>Nữ</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email_new" name="email_new" required value="<?= $_SESSION['user']->email ?>">
                        </div>
                        <div class="col">
                            <label for="password_new" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password_new" name="password_new" value="" placeholder="Bỏ qua nếu không đổi mật khẩu">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="sodienthoai" class="form-label">Số điện thoại</label>
                            <input type="tel" pattern="[0-9]{10}" minlength="10" maxlength="10" class="form-control" id="sodienthoai" name="sodienthoai" required value="<?= $_SESSION['user']->sodienthoai ?>">
                        </div>
                    </div>
                    <div class="col">
                        <label for="diachi" class="form-label">Địa chỉ</label>
                        <input type="diachi" class="form-control" id="diachi" name="diachi" required value="<?= $_SESSION['user']->diachi ?>">
                    </div>
                    <br />
                    <div class="col text-center">
                        <button type="submit" class="btn btn-danger w-100">chỉnh sửa</button>
                    </div>
                </form>
                <hr>
                <p class="footer-text">Mua tiếp nào ! <a href="../../index.php?pages=trang-chu" class="text-danger">Về trang chủ</a></p>
            </div>
        </div>

    </div>


    <script src="../../assets/vendor/jquery-3.7.1.js"></script>
    <script src="../../assets/vendor/bootstrap-5.2.3-dist/js/bootstrap.min.js"></script>
    <script src="../../assets/vendor/sweetalert2@11.js"></script>

    <?php if (isset($_GET['msg'])) {
        switch ($_GET['msg']) {
            case 'success':
                echo "<script>
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    Toast.fire({
                        icon: 'success',
                        title: 'Cập nhật thành công!'
                    });
                </script>";
                break;

            case 'error':
                echo "<script>
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                            }
                        });
                        Toast.fire({
                            icon: 'error',
                            title: 'Cập nhật không thành công!'
                        });
                    </script>";
                break;

            case 'warning':
                echo "<script>
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                            }
                        });
                        Toast.fire({
                            icon: 'warning',
                            title: 'Thông tin đăng nhập không chính xác hoặc tài khoản bị khóa!'
                        });
                    </script>";
                break;
        }
    } ?>
</body>

</html> -->