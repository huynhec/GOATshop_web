<?php
require_once '../../../model/LoaiSpModel.php';
$loaisp = new LoaiSpModel();

if (isset($_GET['req'])) {
    switch ($_GET['req']) {
        case "add":
            $res = 0;
            $tenloai = $_POST['tenloai'];
            $trangthai = $_POST['trangthai'];
            $mota = $_POST['mota'] != "" ? $_POST['mota'] : 'Đang cập nhật';
            $res += $loaisp->LoaiSp__Add($tenloai, $mota, $trangthai);
            if ($res != 0) {
                header('location: ../../index.php?pages=loai-sp&msg=success');
            } else {
                header('location: ../../index.php?pages=loai-sp&msg=error');
            }
            break;

        case "update":
            $res = 0;
            $maloai = $_POST['maloai'];
            $tenloai = $_POST['tenloai'];
            $mota = $_POST['mota'];
            $trangthai = $_POST['trangthai'];
            $res += $loaisp->LoaiSp__Update($maloai, $tenloai, $mota, $trangthai);
            if ($res != 0) {
                header('location: ../../index.php?pages=loai-sp&msg=success');
            } else {
                header('location: ../../index.php?pages=loai-sp&msg=error');
            }
            break;

        case "delete":
            $res = 0;
            $maloai = $_GET['maloai'];
            $res += $loaisp->LoaiSp__Delete($maloai);
            if ($res != 0) {
                header('location: ../../index.php?pages=loai-sp&msg=success');
            } else {
                header('location: ../../index.php?pages=loai-sp&msg=error');
            }
            break;
        default:
            break;
    }
}
