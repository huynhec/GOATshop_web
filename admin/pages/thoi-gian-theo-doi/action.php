<?php

require('../../../assets/vendor/PHPOffice/PHPExcel.php');
require_once '../../../model/ImportModel.php';
$import = new ImportModel();

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
            $importData = $import->import_Tracking__Get_All();

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
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $row_hd, "" . $item->user);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $row_hd, "" . $item->item);
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $row_hd, "" . $item->rating);
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

            // Thiết lập đường dẫn đến Python
            $pythonPath = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') ?
                "%USERPROFILE%\\Anaconda3\\python.exe" :
                "/opt/anaconda3/bin/python";

            // // Thiết lập lệnh Python với đường dẫn và tên file
            // $pythonCommand = 'conda run --name code ' . $pythonPath . " main.py 2>&1";
            // Thiết lập đường dẫn đến Python
            // $pythonPath = "/opt/anaconda3/envs/python=3.9/bin/python";
            // $pythonCommand = 'source activate python=3.9 ' . $pythonPath . " main.py 2>&1";

            $command = "source /opt/anaconda3/bin/activate; /opt/anaconda3/envs/python=3.9/bin/python main.py 2>&1";
            $output = shell_exec($command);


            // encoding  UTF-8
            // putenv("PYTHONIOENCODING=utf-8");

            // Thực thi lệnh Python
            // $output = shell_exec($pythonCommand);

            // Tiếp tục xử lý với tệp kết quả
            $fileToImport = $fileDir . '4_prediction_export.xlsx';

            // Thực hiện nhập dữ liệu từ tệp Excel
            $importStatus = 0;

            if (file_exists($fileToImport)) {
                // Xóa dữ liệu hiện có trước khi nhập
                $import->import__Delete_User_Based();

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
                    $importStatus .= $import->import__Add_User_Based($user, $rank, $item);
                }
            }

            echo ($importStatus != 0) ? "success" : "failed";

            break;



        case "export":

            $status = 0;

            $import__Get_All = $import->import_Tracking__Get_All();

            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);

            $row_hd = 2;

            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);


            $objPHPExcel->getActiveSheet()->SetCellValue('A1', "user");
            $objPHPExcel->getActiveSheet()->SetCellValue('B1', "item");
            $objPHPExcel->getActiveSheet()->SetCellValue('C1', "rating");


            foreach ($import__Get_All as $item) {
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $row_hd, "" . $item->user);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $row_hd, "" . $item->item);
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $row_hd, "" . $item->rating);


                $row_hd += 1;
            }

            $file = 'export.xlsx';
            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            try {
                $objWriter->save($file);
            } catch (PHPExcel_Writer_Exception $e) {
                // If saving fails, try saving to backup directory
                $file = '/Applications/XAMPP/xamppfiles/temp/export.xlsx';
                $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
                $objWriter->save($file);
            }
            // download
            header('Content-Description: File Transfer');
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            // xóa file tạm
            $status .= unlink($file);

            if ($status == 0) {
                header("location:../../index.php?pages=thoi-gian-theo-doi&status=fail");
            } else {
                header("location:../../index.php?pages=thoi-gian-theo-doi&status=success");
            }
            break;

        case "import":
            $status = 0;

            $file = $_FILES["file"]["tmp_name"];
            if (isset($file)) {
                $objReader = PHPExcel_IOFactory::createReaderForFile($file);
                // $objReader->setLoadSheetsOnly();
                $objExcel = $objReader->load($file);
                $sheetData = $objExcel->getActiveSheet()->toArray(null, true, true, true);
                $highestRow = $objExcel->setActiveSheetIndex()->getHighestRow();


                for ($row = 2; $row <= $highestRow; $row++) {
                    $user = $sheetData[$row]['A'];
                    $item = $sheetData[$row]['B'];
                    $rating = $sheetData[$row]['C'];

                    $importStatus .= $import->import__Add_User_Based($user, $item, $rating);
                }
            }

            if ($status == 0) {
                header("location:../../index.php?pages=thoi-gian-theo-doi&status=fail");
            } else {
                header("location:../../index.php?pages=thoi-gian-theo-doi&status=success");
            }
            break;
    }
}
