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
            $ngaythem = date("Y-m-d_H-i-s");
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

        case "c_update":
            $res = 0;
            $id_banner = $_POST["id_banner"];
            $anhbanner_cu = $_POST['anhbanner_cu'];
            $foldername = $bn->Folder_Banner__Get_by_Id($id_banner);
            // Kiểm tra xem có tệp ảnh đã tải lên không
            if (!empty($_FILES["anhbanner"]["name"])) {
                // Kiểm tra và xử lý tệp
                $processedImageFilePath = $cm->processAndValidateUploadedFileNotArrays($_FILES["anhbanner"], $foldername->truncated_anhbanner);

                if ($processedImageFilePath) {
                    // Sử dụng đường dẫn tệp để hiển thị hoặc lưu vào cơ sở dữ liệu
                    $anhbanner = $processedImageFilePath;
                } else {
                    // Sử dụng hình ảnh cũ nếu không có tệp ảnh được tải lên
                    $anhbanner = $_POST['anhbanner_cu'];
                }
            } else {
                // Sử dụng hình ảnh cũ nếu không có tệp ảnh được tải lên
                $anhbanner = $_POST['anhbanner_cu'];
            }
            // Xóa ảnh nếu đường dẫn tồn tại
            if (file_exists("../../../assets/$anhbanner_cu")) {
                unlink("../../../assets/$anhbanner_cu");
            }
            $res += $bn->Anh_Banner__Update($id_banner, $anhbanner);

            if ($res != 0) {
                header("location: ../../index.php?pages=anh-banner&id_banner=$id_banner&msg=success");
            } else {
                header("location: ../../index.php?pages=anh-banner&id_banner=$id_banner&msg=error");
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
