<?php
require_once '../../../model/TrangThaiModel.php';
$tt = new TrangThaiModel();

if (isset($_GET['req'])) {
    switch ($_GET['req']) {
        case "add":
            $res = 0;
            $tentt = $_POST['tentt'];
            $mota = $_POST['mota'] != "" ? $_POST['mota'] : 'Đang cập nhật';
            $res += $tt->TrangThai__Add($tentt, $mota);
            if ($res != 0) {
                header('location: ../../index.php?pages=trang-thai&msg=success');
            } else {
                header('location: ../../index.php?pages=trang-thai&msg=error');
            }
            break;

        case "update":
            $res = 0;
            $matt = $_POST['matt'];
            $tentt = $_POST['tentt'];
            $mota = $_POST['mota'];
            $res += $tt->TrangThai__Update($matt, $tentt, $mota);
            if ($res != 0) {
                header('location: ../../index.php?pages=trang-thai&msg=success');
            } else {
                header('location: ../../index.php?pages=trang-thai&msg=error');
            }
            break;

        case "delete":
            $res = 0;
            $matt = $_GET['matt'];
            $res += $tt->TrangThai__Delete($matt);
            if ($res != 0) {
                header('location: ../../index.php?pages=trang-thai&msg=success');
            } else {
                header('location: ../../index.php?pages=trang-thai&msg=error');
            }
            break;
        default:
            break;
    }
}
