<?php
require_once '../../../model/SanPhamModel.php';
require_once '../../../model/AnhSpModel.php';
require_once '../../../model/CommonModel.php';
require_once '../../../model/ThuocTinhModel.php';
require_once '../../../model/ChiTietThuocTinhModel.php';
require_once '../../../model/DonGiaModel.php';

$dg = new DonGiaModel();
$sp = new SanPhamModel();
$anhSp = new AnhSpModel();
$cm = new CommonModel();
$thuoctinh = new ThuocTinhModel();
$chitietthuoctinh = new ChiTietThuocTinhModel();
$defaultImagePath = "uploads/cover.png";

if (isset($_GET['req'])) {
    switch ($_GET['req']) {
        case "add":
            $tensp = $_POST["tensp"];
            $dongia = $_POST["dongia"];
            $mota = $_POST["mota"];
            $ngaythem = date("Y-m-d H:i:s");
            $trangthai = $_POST["trangthai"];
            $luotmua = 0;
            $luotxem = 0;
            $math = $_POST["math"];
            $maloai = $_POST["maloai"];
            $masp = $sp->SanPham__Add($tensp, $mota, $ngaythem, $trangthai, $luotmua, $luotxem, $math, $maloai);
            $idtt = $_POST["idtt"] != "" ? $_POST["idtt"] : 0;
            $noidung = $_POST["noidung"];
            $apdung = 1;
            $ngaynhap = date("Y-m-d H:i:s");

            if (isset($idtt) && $idtt > 0) {
                for ($i = 0; $i < count($idtt); $i++) {
                    $chitietthuoctinh__Add = $chitietthuoctinh->ChiTietThuocTinh__Add($idtt[$i], $masp, $noidung[$i]);
                }
            }

            if (isset($_POST['dongia']) && is_array($_POST['dongia'])) {
                foreach ($_POST['dongia'] as $item) {
                    // Xử lý và lưu vào cơ sở dữ liệu ở đây
                    $dongia = $item;
                    $res += $dg->DonGia__Add($dongia, $apdung, $ngaynhap, $masp);
                }
            }
            $totalRes = 0;

            // Kiểm tra xem có tệp ảnh đã tải lên không
            if (!empty($_FILES["anhsp"]["name"])) {

                // Tạo một mảng để lưu trữ đường dẫn ảnh cho mỗi sp
                $anhsp = [];

                foreach ($_FILES["anhsp"]["name"] as $key => $filename) {
                    // Xử lý và kiểm tra tệp ảnh
                    $processedImageFilePath = $cm->processAndValidateUploadedFile($_FILES["anhsp"], $masp, $key);

                    // Kiểm tra xem xử lý tệp ảnh thành công hay không
                    if ($processedImageFilePath) {
                        // Lưu đường dẫn ảnh vào mảng và thêm vào cơ sở dữ liệu
                        $anhsp[$key] = $processedImageFilePath;
                        $totalRes += $anhSp->AnhSp__Add($processedImageFilePath, $masp);
                    } else {
                        // Sử dụng hình ảnh mặc định nếu xử lý thất bại và thêm vào cơ sở dữ liệu
                        $anhsp[$key] = $defaultImagePath;
                        $totalRes += $anhSp->AnhSp__Add($defaultImagePath, $masp);
                    }
                }
            } else {
                // Sử dụng hình ảnh mặc định nếu không có tệp ảnh được tải lên và thêm vào cơ sở dữ liệu
                $totalRes += $anhSp->AnhSp__Add($defaultImagePath, $masp);
            }

            if ($totalRes > 0 && $masp > 0) {
                header("location: ../../index.php?pages=san-pham&msg=success");
                exit();
            } else {
                header("location: ../../index.php?pages=san-pham&msg=error");
                exit();
            }

            break;
        case "update":
            $res = 0;
            $masp = $_POST['masp'];
            $tensp = $_POST["tensp"];
            $mota = $_POST["mota"];
            $ngaythem = date("Y-m-d H:i:s");
            $trangthai = $_POST["trangthai"];
            $luotmua = $_POST["luotmua"];
            $luotxem = $_POST["luotxem"];
            $math = $_POST["math"];
            $maloai = $_POST["maloai"];

            $id_cttt = $_POST["id_cttt"];
            $idtt = $_POST["idtt"] != "" ? $_POST["idtt"] : 0;
            $noidung = $_POST["noidung"];

            if (isset($idtt) && $idtt > 0) {
                for ($i = 0; $i < count($idtt); $i++) {
                    $chitietthuoctinh__Update = $chitietthuoctinh->ChiTietThuocTinh__Update($id_cttt[$i], $idtt[$i], $masp, $noidung[$i]);
                }
            }

            $res += $sp->SanPham__Update($masp, $tensp, $mota, $ngaythem, $trangthai, $luotmua, $luotxem, $math, $maloai);
            if ($res != 0) {
                header('location: ../../index.php?pages=san-pham&msg=success');
            } else {
                header('location: ../../index.php?pages=san-pham&msg=error');
            }
            break;

        case "delete":
            $res = 0;
            $masp = $_GET['masp'];
            foreach ($anhSp->AnhSp__Get_By_Id_Sp($masp) as $item) {
                unlink("../../../assets/" . $item->hinhanh);
                rmdir("../../../assets/uploads/$masp");
            }
            $res += $anhSp->AnhSp__Delete_By_Id_Sp($masp);
            $res += $sp->SanPham__Delete($masp);

            if ($res != 0) {
                header('location: ../../index.php?pages=san-pham&msg=success');
            } else {
                header('location: ../../index.php?pages=san-pham&msg=error');
            }
            break;

        case "c_add":
            $masp = $_POST["masp"];
            $totalRes = 0;
            // Kiểm tra xem có tệp ảnh đã tải lên không
            if (!empty($_FILES["anhsp"]["name"])) {

                // Tạo một mảng để lưu trữ đường dẫn ảnh cho mỗi sản phẩm
                $product_images = [];

                foreach ($_FILES["anhsp"]["name"] as $key => $filename) {
                    // Xử lý và kiểm tra tệp ảnh
                    $processedImageFilePath = $cm->processAndValidateUploadedFile($_FILES["anhsp"], $masp, $key);

                    // Kiểm tra xem xử lý tệp ảnh thành công hay không
                    if ($processedImageFilePath) {
                        // Lưu đường dẫn ảnh vào mảng và thêm vào cơ sở dữ liệu
                        $product_images[$key] = $processedImageFilePath;
                        $totalRes += $anhSp->AnhSp__Add($processedImageFilePath, $masp);
                    } else {
                        // Sử dụng hình ảnh mặc định nếu xử lý thất bại và thêm vào cơ sở dữ liệu
                        $product_images[$key] = $defaultImagePath;
                        $totalRes += $anhSp->AnhSp__Add($defaultImagePath, $masp);
                    }
                }
            } else {
                // Sử dụng hình ảnh mặc định nếu không có tệp ảnh được tải lên và thêm vào cơ sở dữ liệu
                $totalRes += $anhSp->AnhSp__Add($defaultImagePath, $masp);
            }


            if ($totalRes > 0) {
                header("Location: ../../index.php?pages=anh-san-pham&masp=$masp&msg=success");
                exit();
            } else {
                header("Location: ../../index.php?pages=anh-san-pham&masp=$masp&msg=error");
                exit();
            }


        case "c_update":
            $res = 0;
            $maanh = $_POST["maanh"];
            $masp = $_POST["masp"];
            $anhsp_cu = $_POST['anhsp_cu'];
            // Kiểm tra xem có tệp ảnh đã tải lên không
            if (!empty($_FILES["anhsp"]["name"])) {
                // Kiểm tra và xử lý tệp
                $processedImageFilePath = $cm->processAndValidateUploadedFile($_FILES["anhsp"], $masp);

                if ($processedImageFilePath) {
                    // Sử dụng đường dẫn tệp để hiển thị hoặc lưu vào cơ sở dữ liệu
                    $anhsp = $processedImageFilePath;
                } else {
                    // Sử dụng hình ảnh cũ nếu không có tệp ảnh được tải lên
                    $anhsp = $_POST['anhsp_cu'];
                }
            } else {
                // Sử dụng hình ảnh cũ nếu không có tệp ảnh được tải lên
                $anhsp = $_POST['anhsp_cu'];
            }
            // Xóa ảnh nếu đường dẫn tồn tại
            if (file_exists("../../../assets/$anhsp_cu")) {
                chmod("../../../assets/$anhsp_cu", 0755); // Thiết lập quyền cho tệp cũ
                unlink("../../../assets/$anhsp_cu");
            }
            $res += $anhSp->AnhSp__Update($maanh, $anhsp, $masp);

            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            
            if ($res != 0) {
                header("location: ../../index.php?pages=anh-san-pham&masp=$masp&msg=success");
            } else {
                header("location: ../../index.php?pages=anh-san-pham&masp=$masp&msg=error");
            }
            break;

        case "c_delete":
            $res = 0;
            $maanh = $_GET["maanh"];
            $masp = $anhSp->AnhSp__Get_By_Id($maanh)->masp;
            $anhsp = $anhSp->AnhSp__Get_By_Id($maanh)->anhsp;
            // Xóa ảnh nếu đường dẫn tồn tại
            if (file_exists("../../../assets/$anhsp")) {
                unlink("../../../assets/$anhsp");
            }
            $res += $anhSp->AnhSp__Delete($maanh);
            if ($res != 0) {
                header("location: ../../index.php?pages=anh-san-pham&masp=$masp&msg=success");
            } else {
                header("location: ../../index.php?pages=anh-san-pham&masp=$masp&msg=error");
            }
            break;
        case "gia_add":
            $res = 0;
            $masp = $_POST["masp"];
            $dongia = $_POST["dongia"];
            $apdung = 1;
            $ngaynhap = date("Y-m-d H:i:s");
            if (isset($_POST['dongia']) && is_array($_POST['dongia'])) {
                foreach ($_POST['dongia'] as $item) {
                    // Xử lý và lưu vào cơ sở dữ liệu ở đây
                    $dongia = $item;
                    $res += $dg->DonGia__Add($dongia, $apdung, $ngaynhap, $masp);
                }
            }
            if ($res != 0) {
                header("location: ../../index.php?pages=san-pham#product_" . $masp);
            } else {
                header("location: ../../index.php?pages=san-pham&msg=error");
            }
            break;
        case "gia_update":
            $res = 0;
            $id_dongia = $_POST["id_dongia"];
            $masp = $_POST['masp'];

            $res += $dg->DonGia__Update_ApDung($masp, $id_dongia);

            // if ($res != 0) {
            //     header("location: ../../index.php?pages=dongia-san-pham&msg=success");
            // } else {
            //     header("location: ../../index.php?pages=dongia-san-pham&msg=error");
            // }
            break;
        default:
            break;
    }
}
