<?php

require('../../../assets/vendor/PHPOffice/PHPExcel.php');
require_once '../../../model/ImportModel.php';
$import = new ImportModel();

if (isset($_GET['req'])) {
    switch ($_GET['req']) {
        case "import":
            $status = 0;

            $file = $_FILES["file"]["tmp_name"];
            if (isset($file)) {
                $objReader = PHPExcel_IOFactory::createReaderForFile($file);
                $objReader->setLoadSheetsOnly();
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
                header("location:../../index.php?pages=import-from-excel&status=fail");
            } else {
                header("location:../../index.php?pages=import-from-excel&status=success");
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
            // lưu file 
            $file = 'export.xlsx';
            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            $objWriter->save($file);

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