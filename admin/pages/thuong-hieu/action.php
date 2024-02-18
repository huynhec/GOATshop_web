<?php
require_once '../../../model/ThuongHieuModel.php';
$th = new ThuongHieuModel();

if (isset($_GET['req'])) {
    switch ($_GET['req']) {
        case "add":
                        // Bật tất cả các báo cáo lỗi
                        error_reporting(E_ALL);

                        // Hiển thị lỗi ngay trên trang web
                        ini_set('display_errors', 1);
            $res = 0;
            $tenth = $_POST['tenth'];
            $trangthai = $_POST['trangthai'];
            $mota = $_POST['mota'] != "" ? $_POST['mota'] : 'Đang cập nhật';
            $res += $th->ThuongHieu__Add($tenth, $mota, $trangthai);
            if ($res != 0) {
                header('location: ../../index.php?pages=thuong-hieu&msg=success');
            } else {
                header('location: ../../index.php?pages=thuong-hieu&msg=error');
            }
            break;

        case "update":
            $res = 0;
            $math = $_POST['math'];
            $tenth = $_POST['tenth'];
            $trangthai = $_POST['trangthai'];
            $mota = $_POST['mota'];
            $res += $th->ThuongHieu__Update($math, $tenth, $mota, $trangthai);
            if ($res != 0) {
                header('location: ../../index.php?pages=thuong-hieu&msg=success');
            } else {
                header('location: ../../index.php?pages=thuong-hieu&msg=error');
            }
            break;

        case "delete":
            $res = 0;
            $math = $_GET['math'];
            $res += $th->ThuongHieu__Delete($math);
            if ($res != 0) {
                header('location: ../../index.php?pages=thuong-hieu&msg=success');
            } else {
                header('location: ../../index.php?pages=thuong-hieu&msg=error');
            }
            break;
        default:
            break;
    }
}
