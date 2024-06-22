<?php
require_once '../../../model/SanPhamModel.php';
require_once '../../../model/AnhSpModel.php';
require_once '../../../model/CommonModel.php';
require_once '../../../model/ThuocTinhModel.php';
require_once '../../../model/ChiTietThuocTinhModel.php';
require_once '../../../model/DonGiaModel.php';
require_once '../../../model/BannerModel.php';

$dg = new DonGiaModel();
$sp = new SanPhamModel();
$anhSp = new AnhSpModel();
$cm = new CommonModel();
$bn = new BannerModel();
$thuoctinh = new ThuocTinhModel();
$chitietthuoctinh = new ChiTietThuocTinhModel();
$defaultImagePath = "uploads/cover.png";

if (isset($_GET['req'])) {
    switch ($_GET['req']) {
        case "add":
            $tenbanner = $_POST["tenbanner"];
            $ngaythem = date("Y-m-d H:i:s");
            $trangthai = $_POST["trangthai"];
            //tạo tên folder
            $foldername = 'banner_' . $ngaythem;
            $totalRes = 0;

            // Kiểm tra xem có tệp ảnh đã tải lên không
            if (isset($_FILES["anhsp"]["name"]) && !empty($_FILES["anhsp"]["name"])) {

                // Tạo một mảng để lưu trữ đường dẫn ảnh cho mỗi sp
                $anhsp = ''; // Khai báo biến chuỗi để lưu trữ đường dẫn ảnh

                $fileName = $_FILES["anhsp"]["name"];

                // Xử lý và kiểm tra tệp ảnh
                $processedImageFilePath = $cm->processAndValidateUploadedFileNotArray($_FILES["anhsp"], $foldername);

                // Kiểm tra xem xử lý tệp ảnh thành công hay không
                if ($processedImageFilePath) {
                    // Lưu đường dẫn ảnh vào mảng và thêm vào cơ sở dữ liệu
                    $anhsp = $processedImageFilePath;
                    $totalRes += $bn->Banner__Add($tenbanner, $processedImageFilePath, $trangthai);
                } else {
                    // Sử dụng hình ảnh mặc định nếu xử lý thất bại và thêm vào cơ sở dữ liệu
                    $anhsp = $defaultImagePath;
                    $totalRes += $bn->Banner__Add($tenbanner, $defaultImagePath, $trangthai);
                }
            } else {
                // Sử dụng hình ảnh mặc định nếu không có tệp ảnh được tải lên và thêm vào cơ sở dữ liệu
                $totalRes += $bn->Banner__Add($tenbanner, $defaultImagePath, $trangthai);
            }

            if ($totalRes > 0 && $foldername > 0) {
                header("location: ../../index.php?pages=banner&msg=success");
                exit();
            } else {
                header("location: ../../index.php?pages=banner&msg=error");
                exit();
            }

            break;
        case "update":
            $res = 0;
            $id_banner = $_POST['id_banner'];
            $tenbanner = $_POST["tenbanner"];
            $trangthai = $_POST["trangthai"];


            $res += $bn->Banner__Update($id_banner, $tenbanner, $trangthai);
            if ($res != 0) {
                header('location: ../../index.php?pages=banner&msg=success');
            } else {
                header('location: ../../index.php?pages=banner&msg=error');
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
                unlink("../../../assets/$anhsp_cu");
            }
            $res += $anhSp->AnhSp__Update($maanh, $anhsp, $masp);

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
        default:
            break;
    }
}
