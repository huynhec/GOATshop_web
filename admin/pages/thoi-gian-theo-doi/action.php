<?php

require('../../../assets/vendor/PHPOffice/PHPExcel.php');
require_once '../../../model/ImportModel.php';
$import = new ImportModel();

if (isset($_GET['req'])) {
    switch ($_GET['req']) {


        case "create_data":
            // xuat excel
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

            $file = __DIR__ . 'training_user_based.xlsx';
            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            try {
                $objWriter->save($file);
            } catch (PHPExcel_Writer_Exception $e) {
                // If saving fails, try saving to backup directory
                $file = '/Applications/XAMPP/xamppfiles/temp/training_user_based.xlsx';
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
            echo $file;

            // Thuc thi traing
            // Đợi 30 giây
            // sleep(10);

            break;
        case 'training':

            // Thực thi training sau khi đợi 30 giây
            $command = "source /opt/anaconda3/bin/activate; python test.py 2>&1";
            $output = shell_exec($command);

            // sleep(5);
            // Import from the specified file
            $importStatus = 0;
            $fileToImport = __DIR__ . '/result/4_prediction_export.xlsx';

            if (file_exists($fileToImport)) {
                $import->import__Delete_User_Based();
                $reader = PHPExcel_IOFactory::createReaderForFile($fileToImport);
                $spreadsheet = $reader->load($fileToImport);
                $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                $highestRow = $spreadsheet->getActiveSheet()->getHighestRow();
                $import->import__Delete_User_Based();
                for ($row = 2; $row <= $highestRow; $row++) {
                    $user = $sheetData[$row]['A'];
                    $rank = $sheetData[$row]['B'];
                    $item = $sheetData[$row]['C'];

                    $importStatus .= $import->import__Add_User_Based($user, $rank, $item);
                }
            }
            echo 1;
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
                header("location:../../index.php?pages=import-from-excel&status=fail");
            } else {
                header("location:../../index.php?pages=import-from-excel&status=success");
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
                header("location:../../index.php?pages=import-from-excel&status=fail");
            } else {
                header("location:../../index.php?pages=import-from-excel&status=success");
            }
            break;
    }
}
