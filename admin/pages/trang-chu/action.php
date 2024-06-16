<?php

require('../../../assets/vendor/PHPOffice/PHPExcel.php');
require_once '../../../model/ImportModel.php';
require_once '../../../model/DonHangModel.php';
require_once '../../../model/SanPhamModel.php';
require_once '../../../model/ChiTietDonHangModel.php';
$dh = new DonHangModel();
$import = new ImportModel();
$sp = new SanPhamModel();
$ctdh = new ChiTietDonHangModel();
if (isset($_GET['req'])) {
    switch ($_GET['req']) {

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
                header("location:../../index.php?pages=import-from-excel&status=fail");
            } else {
                header("location:../../index.php?pages=import-from-excel&status=success");
            }
            break;

        case "export":

            $status = 0;


            $thongKe__Get_All = $ctdh->ThongKe__Get_All();
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);




            // Set headers
            $objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'MÃ ĐƠN');
            $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'HỌ TÊN');
            $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'SỐ ĐIỆN THOẠI');
            $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'NGÀY ĐẶT');
            $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'TỔNG TIỀN');
            $objPHPExcel->getActiveSheet()->mergeCells('E1:G1');

            // Set alignment and style for headers
            $headerColumns = ['A', 'B', 'C', 'D'];
            foreach ($headerColumns as $col) {
                $objPHPExcel->getActiveSheet()->getStyle($col . '1')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle($col . '1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            }

            // Define styles
            $styleGray = array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'E5E5E5')
                ),
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '000000')
                    )
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                )
            );

            $styleWhite = array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'FFFFFF')
                ),
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '000000')
                    )
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                )
            );

            // Initialize row number
            $row_hd = 2;
            $isGray = true; // Start with gray

            foreach ($thongKe__Get_All as $item) {
                $currentStyle = $isGray ? $styleGray : $styleWhite;

                $startRow = $row_hd;

                // Fill in order details
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $row_hd, $item->madon);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $row_hd, $item->tenkh);
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $row_hd, $item->sdt);
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $row_hd, $item->ngaythem);
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $row_hd, number_format($item->tongdh) . ' ₫');
                $objPHPExcel->getActiveSheet()->mergeCells('E' . $row_hd . ':G' . $row_hd);

                // Apply style
                $objPHPExcel->getActiveSheet()->getStyle('A' . $row_hd . ':G' . $row_hd)->applyFromArray($currentStyle);
                $row_hd++;

                // Fill in product details headers
                $productStartRow = $row_hd;

                $objPHPExcel->getActiveSheet()->getStyle('E' . $row_hd)->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('F' . $row_hd)->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('G' . $row_hd)->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $row_hd, "Tên sản phẩm");
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $row_hd, "Số lượng");
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $row_hd, "Đơn giá");

                // Apply style
                $objPHPExcel->getActiveSheet()->getStyle('B' . $row_hd . ':G' . $row_hd)->applyFromArray($currentStyle);
                $row_hd++;

                // Fill in product details
                foreach ($ctdh->ThongKe__Get_By_Madon($item->madon) as $items) {
                    $objPHPExcel->getActiveSheet()->SetCellValue('E' . $row_hd, ' - ' . $items->tensp);
                    $objPHPExcel->getActiveSheet()->SetCellValue('F' . $row_hd, $items->soluong);
                    $objPHPExcel->getActiveSheet()->SetCellValue('G' . $row_hd, number_format($items->dongia) . ' ₫');

                    // Apply style
                    $objPHPExcel->getActiveSheet()->getStyle('B' . $row_hd . ':G' . $row_hd)->applyFromArray($currentStyle);
                    $row_hd++;
                }
                // Merge 'madon' cells
                if ($row_hd > $productStartRow) {
                    $objPHPExcel->getActiveSheet()->mergeCells('A' . $startRow . ':A' . ($row_hd - 1));
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $startRow)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->mergeCells('B' . ($startRow + 1) . ':B' . ($row_hd - 1));
                    $objPHPExcel->getActiveSheet()->getStyle('B' . ($startRow + 1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->mergeCells('C' . ($startRow + 1) . ':C' . ($row_hd - 1));
                    $objPHPExcel->getActiveSheet()->getStyle('C' . ($startRow + 1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->mergeCells('D' . ($startRow + 1) . ':D' . ($row_hd - 1));
                    $objPHPExcel->getActiveSheet()->getStyle('D' . ($startRow + 1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                }

                // Toggle color for next order
                $isGray = !$isGray;
            }
            // Tự động căn chỉnh độ rộng các cột trước khi nhập dữ liệu
            foreach (range('A', 'G') as $columnID) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
            }


            $dataColumns = ['A', 'E', 'F', 'G'];
            for ($i = 2; $i < $row_hd; $i++) {
                foreach ($dataColumns as $col) {
                    $objPHPExcel->getActiveSheet()->getStyle($col . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                }
            }

            $objPHPExcel->getActiveSheet()->calculateColumnWidths();

            $date = date('Y-m-d');
            $file = 'Thongke_' . $date . '.xlsx';
            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            try {
                $objWriter->save($file);
            } catch (PHPExcel_Writer_Exception $e) {
                // If saving fails, try saving to backup directory
                $file = '/Applications/XAMPP/xamppfiles/temp/' . 'Thongke_' . $date . '.xlsx';
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
