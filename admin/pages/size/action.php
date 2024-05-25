<?php
require_once '../../../model/SizeModel.php';
require_once '../../../model/LoaiSpModel.php';
$size = new SizeModel();
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
            $maloai = $_POST['maloai'];

            if (isset($_POST['tensize']) && is_array($_POST['tensize'])) {
                foreach ($_POST['tensize'] as $key => $tensize) {
                    $trangthai = $_POST['trangthai'][$key];
                    // Xử lý và lưu vào cơ sở dữ liệu ở đây
                    $res += $size->Size__Add($tensize, $trangthai, $maloai);
                }
            }


            if ($res != 0) {
                header('location: ../../index.php?pages=size&msg=success');
            } else {
                header('location: ../../index.php?pages=size&msg=error');
            }
            break;

        case "update":
            $res = 0;
            $idsize = $_POST['idsize'];
            $tensize = $_POST['tensize'];
            $trangthai = $_POST['trangthai'];
            $maloai = $_POST['maloai'];

            $res += $size->Size__Update($tensize,  $trangthai, $maloai, $idsize);
            if ($res != 0) {
                header('location: ../../index.php?pages=size&msg=success');
            } else {
                header('location: ../../index.php?pages=size&msg=error');
            }
            break;

        case "s_update":
            $res = 0;
            if (isset($_POST['idsize']) && isset($_POST['tensize']) && isset($_POST['trangthai']) && isset($_POST['maloai'])) {
                $idsize = $_POST['idsize'];
                $tensize = $_POST['tensize'];
                $trangthai = $_POST['trangthai'];
                $maloai = $_POST['maloai'];

                for ($i = 0; $i < count($idsize); $i++) {
                    echo $tensize[$i];
                    echo $trangthai[$i];
                    echo $maloai;
                    echo $idsize[$i];

                    // Xử lý và lưu vào cơ sở dữ liệu ở đây
                    $res += $size->Size__Update($tensize[$i], $trangthai[$i],  $maloai, $idsize[$i]);
                }
            } else {
                // Xử lý khi dữ liệu không tồn tại
            }

            if ($res != 0) {
                header('location: ../../index.php?pages=size&msg=success');
            } else {
                header('location: ../../index.php?pages=size&msg=error');
            }
            break;

        case "delete":
            $res = 0;
            $idsize = $_GET['idsize'];
            $res += $size->Size__Delete($idtt);
            if ($res != 0) {
                header('location: ../../index.php?pages=size&msg=success');
            } else {
                header('location: ../../index.php?pages=size&msg=error');
            }
            break;
        default:
            break;
    }
}
