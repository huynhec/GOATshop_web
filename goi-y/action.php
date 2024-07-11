<?php
require_once '../../../model/GoiYModel.php';
require_once '../../../model/RatingsModel.php';
require_once '../../../assets/vendor/PHPOffice/PHPExcel.php';

$rt = new RatingsModel();
$goiy = new GoiYModel();

if (isset($_GET['req'])) {
    switch ($_GET['req']) {



        case 'training':

            // Thử lấy đường dẫn từ __DIR__, nếu không thành công, sử dụng đường dẫn tạm thời
            try {
                $fileDirectory = __DIR__ . '/datasets/';
                // Kiểm tra và tạo thư mục nếu không tồn tại
                if (!file_exists($fileDirectory)) {
                    mkdir($fileDirectory, 777, true);
                }
            } catch (Exception $e) {
                $fileDirectory = '/Applications/XAMPP/xamppfiles/temp/';
                // Kiểm tra và tạo thư mục nếu không tồn tại
                if (!file_exists($fileDirectory)) {
                    mkdir($fileDirectory, 0777, true);
                }
            }

            // Đặt tên và đường dẫn đầy đủ của tệp Excel
            $fileName = 'training_user_based.xlsx';
            $fileFullPath = $fileDirectory . $fileName;

            // Lấy dữ liệu từ $import
            $importData = $rt->Ratings__Get_All();

            // Khởi tạo một đối tượng PHPExcel
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);

            $row_hd = 2;

            // Thiết lập tiêu đề cột
            $objPHPExcel->getActiveSheet()->getStyle('A1:C1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', "user");
            $objPHPExcel->getActiveSheet()->SetCellValue('B1', "item");
            $objPHPExcel->getActiveSheet()->SetCellValue('C1', "rating");

            // Điền dữ liệu vào tệp Excel
            foreach ($importData as $item) {
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $row_hd, "" . $item->idkh);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $row_hd, "" . $item->idsp);
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $row_hd, "" . $item->rating_value);
                $row_hd++;
            }

            // Lưu tệp Excel
            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            $objWriter->save($fileFullPath);

            // Tiếp tục xử lý với thư mục kết quả

            // Thử lấy đường dẫn từ __DIR__, nếu không thành công, sử dụng đường dẫn tạm thời
            try {
                $fileDir = __DIR__ . '/result/';
                // Kiểm tra và tạo thư mục nếu không tồn tại
                if (!file_exists($fileDir)) {
                    mkdir($fileDir, 777, true);
                }
            } catch (Exception $e) {
                $fileDir = '/Applications/XAMPP/xamppfiles/temp/';
                // Kiểm tra và tạo thư mục nếu không tồn tại
                if (!file_exists($fileDir)) {
                    mkdir($fileDir, 0777, true);
                }
            }



            $condaPath = "\"C:\\Users\\Huy\\anaconda3\\Scripts\\activate.bat\""; // Thay đổi đường dẫn tới activate.bat tương ứng trên máy của bạn
            $envPath = "\"C:\\Users\\Huy\\anaconda3\\python.exe\""; // Thay đổi đường dẫn tới python.exe trong môi trường conda của bạn
            $scriptPath = "main.py";
            
            $command = "$condaPath && $envPath $scriptPath 2>&1";
            $output = shell_exec($command);
            


            // encoding  UTF-8
            // putenv("PYTHONIOENCODING=utf-8");

            // Tiếp tục xử lý với tệp kết quả
            $fileToImport = $fileDir . '4_prediction_export.xlsx';

            // Thực hiện nhập dữ liệu từ tệp Excel
            $importStatus = 0;

            if (file_exists($fileToImport)) {
                // Xóa dữ liệu hiện có trước khi nhập
                $goiy->GoiY__Delete_All();

                // Tạo một đối tượng Reader để đọc dữ liệu từ tệp Excel
                $reader = PHPExcel_IOFactory::createReaderForFile($fileToImport);
                $spreadsheet = $reader->load($fileToImport);
                $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                $highestRow = $spreadsheet->getActiveSheet()->getHighestRow();

                // Lặp qua từng dòng trong tệp Excel và nhập dữ liệu
                for ($row = 2; $row <= $highestRow; $row++) {
                    $user = $sheetData[$row]['A'];
                    $rank = $sheetData[$row]['B'];
                    $item = $sheetData[$row]['C'];

                    // Thêm dữ liệu vào cơ sở dữ liệu
                    $importStatus .= $goiy->GoiY__Add($user, $item, $rank);
                }
            }

            echo ($importStatus != 0) ? "success" : "failed";
            if ($importStatus != 0) {
                header("location: ../../index.php?pages=goi-y&msg=success");
            } else {
                header("location: ../../index.php?pages=goi-y&msg=error");
            }
            break;

        case 'training-2':
            try {
                $fileDir = __DIR__ . '/result/';
                // Kiểm tra và tạo thư mục nếu không tồn tại
                if (!file_exists($fileDir)) {
                    mkdir($fileDir, 777, true);
                }
            } catch (Exception $e) {
                $fileDir = '/Applications/XAMPP/xamppfiles/temp/';
                // Kiểm tra và tạo thư mục nếu không tồn tại
                if (!file_exists($fileDir)) {
                    mkdir($fileDir, 0777, true);
                }
            }

            // Thiết lập đường dẫn đến Python
            $command = escapeshellcmd('C:\Users\HP\anaconda3\python.exe main.py');
            $output = shell_exec($command);
            // encoding  UTF-8
            putenv("PYTHONIOENCODING=utf-8");

            // Tiếp tục xử lý với tệp kết quả
            $fileToImport = $fileDir . '4_prediction_export.xlsx';

            // Thực hiện nhập dữ liệu từ tệp Excel
            $importStatus = 0;

            if (file_exists($fileToImport)) {
                // Xóa dữ liệu hiện có trước khi nhập
                $goiy->GoiY__Delete_All();

                // Tạo một đối tượng Reader để đọc dữ liệu từ tệp Excel
                $reader = PHPExcel_IOFactory::createReaderForFile($fileToImport);
                $spreadsheet = $reader->load($fileToImport);
                $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                $highestRow = $spreadsheet->getActiveSheet()->getHighestRow();

                // Lặp qua từng dòng trong tệp Excel và nhập dữ liệu
                for ($row = 2; $row <= $highestRow; $row++) {
                    $user = $sheetData[$row]['A'];
                    $rank = $sheetData[$row]['B'];
                    $item = $sheetData[$row]['C'];

                    // Thêm dữ liệu vào cơ sở dữ liệu
                    $importStatus .= $goiy->GoiY__Add($user, $item, $rank);
                }
            }

            echo ($importStatus != 0) ? "success" : "failed";
            if ($importStatus != 0) {
                header("location: ../../index.php?pages=goi-y&msg=success");
            } else {
                header("location: ../../index.php?pages=goi-y&msg=error");
            }
            break;
        default:
            break;
    }
}
