<?php
session_start();

if (!isset($_SESSION['admin']) && !isset($_SESSION['manager']) && !isset($_SESSION['nhanvien'])) {
    header("location: ../auth/index.php?pages=dang-nhap");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="dynamicTitle">GOATshop</title>
    <link rel="shortcut icon" href="../assets/images/Browser.png" type="image/x-icon">
    <link rel="stylesheet" href="../assets/vendor/bootstrap-5.2.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/vendor/boxicons-2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="../assets/vendor/datatables/css/1_dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../assets/vendor/datatables/css/2_buttons.bootstrap5.min.css">

    <link rel="stylesheet" href="../assets/vendor/daterangejs/daterangepicker.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>

<body>

    <?php require_once 'components/sidebar.php' ?>
    <?php require_once 'components/main.php' ?>

    <script src="../assets/vendor/jquery-3.7.1.js"></script>
    <script src="../assets/vendor/bootstrap-5.2.3-dist/js/bootstrap.min.js"></script>
    <script src="../assets/vendor/sweetalert2@11.js"></script>
    <script src="../assets/vendor/datatables/js/1_jquery.dataTables.min.js"></script>
    <script src="../assets/vendor/datatables/js/2_dataTables.bootstrap5.min.js"></script>

    <script src="../assets/vendor/daterangejs/moment.min.js"></script>
    <script src="../assets/vendor/daterangejs/daterangepicker.min.js"></script>
    <script src="../assets/vendor/ckeditor5-build-classic/ckeditor.js"></script>
    <script src="../assets/js/admin.js"></script>
    <script src="../assets/js/diachi.js"></script>

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
                        title: 'Cập nhật dữ liệu thành công!'
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
                            title: 'Cập nhật dữ liệu không thành công!'
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
                            title: 'Cập nhật dữ liệu bị hủy!'
                        });
                    </script>";
                break;
            case 'file_not_found':
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
                                title: 'Không tìm thấy file, hãy thử lại!'
                            });
                        </script>";
                break;
            case 'fail':
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
                                title: 'Xãy ra lỗi khi training!'
                            });
                        </script>";
                break;
                case 'training_success':
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
                            title: 'Training thành công!'
                        });
                    </script>";
                    break;
        }
    } ?>
</body>

</html>