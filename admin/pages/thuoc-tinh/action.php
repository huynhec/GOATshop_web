<?php
require_once '../../../model/ThuocTinhModel.php';
require_once '../../../model/LoaiSpModel.php';
$tt = new ThuocTinhModel();
$loaisp = new LoaiSpModel();

if (isset($_GET['req'])) {
    switch ($_GET['req']) {
        case "add":
            // Bật tất cả các báo cáo lỗi
            error_reporting(E_ALL);

            // Hiển thị lỗi ngay trên trang web
            ini_set('display_errors', 1);
            $res = 0;
            $trangthai = $_POST['trangthai'];
            $is_num = $_POST['is_num'];
            $maloai = $_POST['maloai'];

            if (isset($_POST['thuoctinh']) && is_array($_POST['thuoctinh'])) {
                foreach ($_POST['thuoctinh'] as $thuoctinh) {
                    // Xử lý và lưu vào cơ sở dữ liệu ở đây
                    $tentt = $thuoctinh;
                    $res += $tt->ThuocTinh__Add($tentt, $trangthai, $is_num, $maloai);
                }
            }


            if ($res != 0) {
                header('location: ../../index.php?pages=thuoc-tinh&msg=success');
            } else {
                header('location: ../../index.php?pages=thuoc-tinh&msg=error');
            }
            break;

        case "update":
            $res = 0;
            $idtt = $_POST['idtt'];
            $tentt = $_POST['tentt'];
            $trangthai = $_POST['trangthai'];
            $is_num = $_POST['is_num'];
            $maloai = $_POST['maloai'];

            $res += $tt->ThuocTinh__Update($tentt, $trangthai, $is_num, $maloai, $idtt);
            if ($res != 0) {
                header('location: ../../index.php?pages=thuoc-tinh&msg=success');
            } else {
                header('location: ../../index.php?pages=thuoc-tinh&msg=error');
            }
            break;

        case "l_update":
            $res = 0;
            $idtt = $_POST['idtt'];
            $tentt = $_POST['tentt'];
            $trangthai = $_POST['trangthai'];
            $maloai = $_POST['maloai'];

            for ($i = 0; $i < count($idtt); $i++) {

                echo $tentt[$i];
                echo $trangthai[$i];
                echo $_POST["is_num_$idtt[$i]"];
                echo $maloai;
                echo $idtt[$i];

                // Xử lý và lưu vào cơ sở dữ liệu ở đây
                $res += $tt->ThuocTinh__Update($tentt[$i], $trangthai[$i], $_POST["is_num_$idtt[$i]"], $maloai, $idtt[$i]);
            }


            if ($res != 0) {
                header('location: ../../index.php?pages=thuoc-tinh&msg=success');
            } else {
                header('location: ../../index.php?pages=thuoc-tinh&msg=error');
            }
            break;
        case "delete":
            $res = 0;
            $idtt = $_GET['idtt'];
            $res += $tt->ThuocTinh__Delete($idtt);
            if ($res != 0) {
                header('location: ../../index.php?pages=thuoc-tinh&msg=success');
            } else {
                header('location: ../../index.php?pages=thuoc-tinh&msg=error');
            }
            break;
        default:
            break;
    }
}
