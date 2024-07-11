<?php

require('../../../assets/vendor/PHPOffice/PHPExcel.php');
require_once '../../../model/ImportModel.php';
$import = new ImportModel();

if (isset($_GET['req'])) {
    switch ($_GET['req']) {

        case "training":

            // Thử lấy đường dẫn từ __DIR__, nếu không thành công, sử dụng đường dẫn tạm thời
            try {
                $fileDirectory = __DIR__ . '/dataset/';
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
            $fileName = 'viewlist.xlsx';
            $fileFullPath = $fileDirectory . $fileName;

            // Lấy dữ liệu từ $import
            $importData = $import->import_View__Get_All();

            // Khởi tạo một đối tượng PHPExcel
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);

            $row_hd = 2;

            // Thiết lập tiêu đề cột
            $objPHPExcel->getActiveSheet()->getStyle('A1:C1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', "ngayxem");
            $objPHPExcel->getActiveSheet()->SetCellValue('B1', "masp");
            $objPHPExcel->getActiveSheet()->SetCellValue('C1', "makh");

            // Điền dữ liệu vào tệp Excel
            foreach ($importData as $item) {
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $row_hd, "" . $item->ngayxem);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $row_hd, "" . $item->masp);
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $row_hd, "" . $item->makh);
                $row_hd++;
            }

            // Lưu tệp Excel
            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            $objWriter->save($fileFullPath);

            // Tiếp tục xử lý với thư mục kết quả

            // Thử lấy đường dẫn từ __DIR__, nếu không thành công, sử dụng đường dẫn tạm thời
            try {
                $fileDir = __DIR__ . '/output/';
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
            // $pythonPath = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') ?
            // "%USERPROFILE%\\Anaconda3\\python.exe" :
            // "/opt/anaconda3/bin/python";
            $condaPath = "\"C:\\Users\\Huynh\\anaconda3\\Scripts\\activate.bat\""; // Thay đổi đường dẫn tới activate.bat tương ứng trên máy của bạn
            $envPath = "\"C:\\Users\\Huynh\\anaconda3\\python.exe\""; // Thay đổi đường dẫn tới python.exe trong môi trường conda của bạn
            $scriptPath1 = "convert.py";
            $scriptPath2 = "main.py";
            // $command = "$condaPath && $envPath $scriptPath 2>&1";


            $pythonPath1 = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') ?
                "$condaPath && $envPath $scriptPath1 2>&1" :
                "source /opt/anaconda3/bin/activate; /opt/anaconda3/envs/python=3.9/bin/python convert.py 2>&1";

            $pythonPath2 = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') ?
                "$condaPath && $envPath $scriptPath2 2>&1" :
                "source /opt/anaconda3/bin/activate; /opt/anaconda3/envs/python=3.9/bin/python main.py 2>&1";



            // $command1 = "source /opt/anaconda3/bin/activate; /opt/anaconda3/envs/python=3.9/bin/python convert.py 2>&1";
            $output1 = shell_exec($pythonPath1);
            // $command2 = "source /opt/anaconda3/bin/activate; /opt/anaconda3/envs/python=3.9/bin/python main.py 2>&1";
            $output2 = shell_exec($pythonPath2);

            // Tiếp tục xử lý với tệp kết quả
            $fileToImport = $fileDir . 'output_rules.xlsx';

            // Thực hiện nhập dữ liệu từ tệp Excel
            $importStatus = 0;

            if (file_exists($fileToImport)) {
                // Xóa dữ liệu hiện có trước khi nhập
                $import->import__Delete_Association_Rules();

                // Tạo một đối tượng Reader để đọc dữ liệu từ tệp Excel
                $reader = PHPExcel_IOFactory::createReaderForFile($fileToImport);
                $spreadsheet = $reader->load($fileToImport);
                $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                $highestRow = $spreadsheet->getActiveSheet()->getHighestRow();

                // Lặp qua từng dòng trong tệp Excel và nhập dữ liệu
                for ($row = 2; $row <= $highestRow; $row++) {
                    $masp = $sheetData[$row]['B'];
                    $masp_rec = $sheetData[$row]['C'];
                    $sup = $sheetData[$row]['D'];
                    $conf = $sheetData[$row]['E'];

                    // Thêm dữ liệu vào cơ sở dữ liệu
                    $importStatus .= $import->import__Add_Association_Rules($masp, $masp_rec, $sup, $conf);
                }
            }

            echo ($importStatus != 0) ? "success" : "failed";
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
                    $masp          = $sheetData[$row]['A'];
                    $masp_rec      = $sheetData[$row]['B'];
                    $sup      = $sheetData[$row]['C'];
                    $conf      = $sheetData[$row]['D'];
                    $status .= $import->import__Add($masp, $masp_rec, $sup, $conf);
                }
            }

            if ($status == 0) {
                header("location:../../index.php?pages=Association-Rules&status=fail");
            } else {
                header("location:../../index.php?pages=Association-Rules&status=success");
            }
            break;

        case "export":

            $status = 0;

            $import__Get_All = $import->import__Get_All();

            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);

            $row_hd = 2;

            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);

            $objPHPExcel->getActiveSheet()->SetCellValue('A1', "masp");
            $objPHPExcel->getActiveSheet()->SetCellValue('B1', "masp_rec");
            $objPHPExcel->getActiveSheet()->SetCellValue('C1', "sup");
            $objPHPExcel->getActiveSheet()->SetCellValue('D1', "conf");
            foreach ($import__Get_All as $item) {
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $row_hd, "" . $item->masp);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $row_hd, "" . $item->masp_rec);
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $row_hd, "" . $item->sup);
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $row_hd, "" . $item->conf);

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
                header("location:../../index.php?pages=Association-Rules&status=fail");
            } else {
                header("location:../../index.php?pages=Association-Rules&status=success");
            }
            break;
    }
}
