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
            $maloai = $_POST['maloai'];
            $is_num = $_POST['is_num'];




            $res += $tt->ThuocTinh__Update($tentt, $trangthai, $is_num, $maloai, $idtt);
            if ($res != 0) {
                header('location: ../../index.php?pages=thuoc-tinh&msg=success');
            } else {
                header('location: ../../index.php?pages=thuoc-tinh&msg=error');
            }
            break;

        case "i_update":
            $res = 0; // Khởi tạo biến $res trước khi sử dụng
            $idtt = $_POST['idtt'];
            $tentt = $_POST['tentt'];
            $trangthai = $_POST['trangthai'];
            $maloai = $_POST['maloai'];

            // Lấy giá trị của is_num dựa trên chỉ số index từ form
            $indexes = $_POST['index']; // Mảng chứa các chỉ số index từ form
            $is_num = []; // Mảng chứa các giá trị is_num
            foreach ($indexes as $index) {
                // Sử dụng isset để kiểm tra xem giá trị is_num có tồn tại không
                // Nếu không tồn tại, gán mặc định là 0
                $is_num_value = isset($_POST['is_num'][$index]) ? $_POST['is_num'][$index] : 0;
                $res += $tt->ThuocTinh__Update($tentt, $trangthai, $is_num_value, $maloai, $idtt[$index]); // Cộng dồn biến $res sau mỗi lần gọi hàm
            }

            if ($res > 0) {
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
