<?php
class CommonModel
{


    function processAndValidateUploadedFile($uploadFile, $folderName, $key=null)
    {
        // Kiểm tra xem tệp có tồn tại không
        $uploadFolder = "../../../assets/uploads/$folderName";

        $tempFilePath = $key !== null ? $uploadFile["tmp_name"][$key] : $uploadFile["tmp_name"];
        if (!file_exists($tempFilePath)) {
            // Hiển thị thông báo lỗi nếu tệp không tồn tại và trả về false
            echo "Lỗi: Tệp không tồn tại.";
            return false;
        }

        // Kiểm tra kích thước của tệp, không xử lý nếu dung lượng vượt quá 200MB
        if (filesize($tempFilePath) > 200 * 1024 * 1024) {
            echo "Cảnh báo: Dung lượng tệp vượt quá 200MB. Sử dụng hình ảnh mặc định.";
            return false;
        }

        // Kiểm tra định dạng ảnh
        $allowedImageTypes = [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF, IMAGETYPE_WEBP];
        $detectedImageType = exif_imagetype($tempFilePath);

        if (!in_array($detectedImageType, $allowedImageTypes)) {
            echo "Cảnh báo: Loại tệp không hợp lệ. Sử dụng hình ảnh mặc định.";
            return false;
        }

        // Tạo thư mục cho truyện nếu nó chưa tồn tại
        
        if (!file_exists($uploadFolder)) {
            mkdir($uploadFolder, 0777, true);
        }

        // Tạo tên tệp dựa trên thời gian và tên gốc của tệp tải lên
        $tempFileName = pathinfo($key !== null ? $uploadFile["name"][$key] : $uploadFile["name"], PATHINFO_FILENAME);
        $uniqueFileName = $tempFileName . "_" . time() . ".png";
        $imageFileName = $uploadFolder . "/" . $uniqueFileName;
        $fileOut = "uploads/$folderName/$uniqueFileName";
        // Di chuyển tệp tải lên vào thư mục đích
        if (move_uploaded_file($tempFilePath, $imageFileName)) {
            // Trả về đường dẫn tệp đã lưu
            return $fileOut;
        } else {
            // Hiển thị thông báo lỗi và trả về false nếu di chuyển tệp thất bại
            echo "Lỗi: Không thể di chuyển tệp tạm sang thư mục đích.";
            return false;
        }
    }
}
