<?php

require('../../../assets/vendor/PHPOffice/PHPExcel.php');
require_once '../../../model/ImportModel.php';
$import = new ImportModel();

if (isset($_GET['req'])) {
    switch ($_GET['req']) {


        case "export":

            $status = 0;

            $import__Get_All = $import->import_View__Get_All();

            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);

            $row_hd = 2;

            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);


            $objPHPExcel->getActiveSheet()->SetCellValue('A1', "makh");
            $objPHPExcel->getActiveSheet()->SetCellValue('B1', "masp");

            foreach ($import__Get_All as $item) {
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $row_hd, "" . $item->makh);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $row_hd, "" . $item->masp);


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
    }
}
