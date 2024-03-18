<?php
require_once '../../../model/LoaiSpModel.php';
$loaisp = new LoaiSpModel();

if (isset($_GET['req'])) {
    switch ($_GET['req']) {
        case "add":
            $res = 0;
            $tenloai = $_POST['tenloai'];
            $trangthai = $_POST['trangthai'];
            $ghichu = null;
            // $mota = $_POST['mota'] != "" ? $_POST['mota'] : 'Đang cập nhật';
            if(isset($_POST['thuoctinh']) && is_array($_POST['thuoctinh'])) {
                foreach($_POST['thuoctinh'] as $thuoctinh) {
                    // Xử lý và lưu vào cơ sở dữ liệu ở đây
                    $tenthuoctinh = $thuoctinh;
                    $res += $loaisp->LoaiSp__Add($tenloai, $tenthuoctinh, $trangthai, $ghichu);
                }
            }
            if ($res != 0) {
                header('location: ../../index.php?pages=loai-sp&msg=success');
            } else {
                header('location: ../../index.php?pages=loai-sp&msg=error');
            }
            break;

        // case "update":
        //     $res = 0;
        //     $maloai = $_POST['maloai'];
        //     $tenloai = $_POST['tenloai'];
        //     $mota = $_POST['mota'];
        //     $trangthai = $_POST['trangthai'];
        //     $res += $loaisp->LoaiSp__Update($maloai, $tenloai, $mota, $trangthai);
        //     if ($res != 0) {
        //         header('location: ../../index.php?pages=loai-sp&msg=success');
        //     } else {
        //         header('location: ../../index.php?pages=loai-sp&msg=error');
        //     }
        //     break;

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
