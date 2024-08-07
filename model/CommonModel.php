<?php
class CommonModel
{


    function processAndValidateUploadedFile($uploadFile, $folderName, $key = null)
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

    function processAndValidateUploadedFileNotArray($uploadFile, $folderName)
    {
        // In ra thông tin của $uploadFile để kiểm tra
        var_dump($uploadFile);

        // Kiểm tra xem tệp có tồn tại không
        $uploadFolder = "../../../assets/uploads/$folderName";
        $tempFilePath = $uploadFile["tmp_name"][0];

        // Kiểm tra và in ra thông tin của $tempFilePath
        var_dump($tempFilePath);

        if (!is_string($tempFilePath) || !file_exists($tempFilePath)) {
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

        // Kiểm tra và in ra thông tin của $detectedImageType
        var_dump($detectedImageType);

        if (!in_array($detectedImageType, $allowedImageTypes)) {
            echo "Cảnh báo: Loại tệp không hợp lệ. Sử dụng hình ảnh mặc định.";
            return false;
        }

        // Tạo thư mục cho ảnh nếu nó chưa tồn tại
        if (!file_exists($uploadFolder)) {
            if (!mkdir($uploadFolder, 0777, true)) {
                echo "Lỗi: Không thể tạo thư mục tải lên.";
                return false;
            }
        }

        // Tạo tên tệp dựa trên thời gian và tên gốc của tệp tải lên
        $tempFileName = pathinfo($uploadFile["name"][0], PATHINFO_FILENAME);
        $uniqueFileName = $tempFileName . "_" . time() . ".png";
        $imageFileName = $uploadFolder . "/" . $uniqueFileName;
        $fileOut = "uploads/$folderName/$uniqueFileName";

        // Kiểm tra và in ra thông tin của các biến đường dẫn
        var_dump($uploadFolder, $imageFileName, $fileOut);

        // Di chuyển tệp tải lên vào thư mục đích
        if (move_uploaded_file($tempFilePath, $imageFileName)) {
            // Trả về đường dẫn tệp đã lưu
            return $fileOut;
        } else {
            // Hiển thị thông báo lỗi và trả về false nếu di chuyển tệp thất bại
            echo "Lỗi: Không thể di chuyển tệp tạm sang thư mục đích.";
            // In ra lỗi chi tiết
            var_dump(error_get_last());
            return false;
        }
    }
    function processAndValidateUploadedFileNotArrays($uploadFile, $folderName)
    {
        // In ra thông tin của $uploadFile để kiểm tra
        var_dump($uploadFile);

        // Kiểm tra xem tệp có tồn tại không
        $uploadFolder = "../../../assets/uploads/$folderName";
        $tempFilePath = $uploadFile["tmp_name"];

        // Kiểm tra và in ra thông tin của $tempFilePath
        var_dump($tempFilePath);

        if (!is_string($tempFilePath) || !file_exists($tempFilePath)) {
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

        // Kiểm tra và in ra thông tin của $detectedImageType
        var_dump($detectedImageType);

        if (!in_array($detectedImageType, $allowedImageTypes)) {
            echo "Cảnh báo: Loại tệp không hợp lệ. Sử dụng hình ảnh mặc định.";
            return false;
        }

        // Tạo thư mục cho ảnh nếu nó chưa tồn tại
        if (!file_exists($uploadFolder)) {
            if (!mkdir($uploadFolder, 0777, true)) {
                echo "Lỗi: Không thể tạo thư mục tải lên.";
                return false;
            }
        }

        // Tạo tên tệp dựa trên thời gian và tên gốc của tệp tải lên
        $tempFileName = pathinfo($uploadFile["name"], PATHINFO_FILENAME);
        $uniqueFileName = $tempFileName . "_" . time() . ".png";
        $imageFileName = $uploadFolder . "/" . $uniqueFileName;
        $fileOut = "uploads/$folderName/$uniqueFileName";

        // Kiểm tra và in ra thông tin của các biến đường dẫn
        var_dump($uploadFolder, $imageFileName, $fileOut);

        // Di chuyển tệp tải lên vào thư mục đích
        if (move_uploaded_file($tempFilePath, $imageFileName)) {
            // Trả về đường dẫn tệp đã lưu
            return $fileOut;
        } else {
            // Hiển thị thông báo lỗi và trả về false nếu di chuyển tệp thất bại
            echo "Lỗi: Không thể di chuyển tệp tạm sang thư mục đích.";
            // In ra lỗi chi tiết
            var_dump(error_get_last());
            return false;
        }
    }




    function getTimeAgo($time)
    {
        if (!is_numeric($time)) {
            $time = strtotime($time);
        }

        $timeDifference = time() - $time;

        if ($timeDifference < 1) {
            return 'Less than 1 second ago';
        }

        $timeUnits = array(
            12 * 30 * 24 * 60 * 60 => 'year',
            30 * 24 * 60 * 60      => 'month',
            24 * 60 * 60           => 'day',
            60 * 60                => 'hour',
            60                     => 'minute',
            1                      => 'second'
        );

        foreach ($timeUnits as $seconds => $unit) {
            $division = $timeDifference / $seconds;

            if ($division >= 1) {
                $roundedValue = round($division);
                return $roundedValue . ' ' . $unit . (($roundedValue > 1) ? 's' : '') . ' ago';
            }
        }
    }

    function formatThousand($number)
    {
        $number = (int) preg_replace('/[^0-9]/', '', $number);

        if ($number >= 1000) {
            $roundedNumber = round($number);
            $formattedNumber = number_format($roundedNumber);
            $numberParts = explode(',', $formattedNumber);
            $magnitudeSuffix = array('K', 'M', 'B', 'T', 'Q');
            $countParts = count($numberParts) - 1;
            $formattedResult = $numberParts[0] . ((int) $numberParts[1][0] !== 0 ? '.' . $numberParts[1][0] : '');
            $formattedResult .= $magnitudeSuffix[$countParts - 1];

            return $formattedResult;
        }

        return $number;
    }
}
