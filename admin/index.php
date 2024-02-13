<?php
session_start();

if (!isset($_SESSION['admin']) && !isset($_SESSION['manager']) && !isset($_SESSION['nhanvien'])) {
    header("location: ../auth/index.php?pages=dang-nhap-admin");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="dynamicTitle">GOATshop</title>

    <link rel="stylesheet" href="../assets/vendor/bootstrap-5.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/vendor/boxicons-2.1.4/css/boxicons.min.css">
    <!-- <link rel="stylesheet" href="../assets/vendor/DataTables/DataTables-1.13.8/css/dataTables.bootstrap5.min.css"> -->

    <link rel="stylesheet" href="../assets/vendor/daterangepicker-master/daterangepicker.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="../assets/vendor/sweetalert2.min.css">
</head>

<body>
    <?php require_once 'components/sidebar.php' ?>
    <?php require_once 'components/main.php' ?>


    <script src="../assets/vendor/jquery-3.7.1.min.js"></script>
    <script src="../assets/vendor/bootstrap-5.3.2/js/bootstrap.min.js"></script>
    <script src="../assets/vendor/sweetalert2.all.min.js"></script>

    <script src="../assets/vendor/DataTables/DataTables-1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="../assets/vendor/DataTables/DataTables-1.13.8/js/dataTables.bootstrap5.min.js"></script>

    <script src="../assets/vendor/daterangepicker-master/moment.min.js"></script>
    <script src="../assets/vendor/daterangepicker-master/daterangepicker.js"></script>
    <script src="../assets/vendor/ckeditor/ckeditor.js"></script>

    <script src="../assets/js/admin.js"></script>

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
        }
    } ?>
</body>

</html>