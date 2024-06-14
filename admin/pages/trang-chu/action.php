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

            $import__Get_All = $import->import__Get_All();
            $donHang__Get_All = $dh->DonHang__Get_All();
            $sanPham__Get_All = $sp->SanPham__Get_All(-1);
            $chiTietDonHang__Get_All = $ctdh->ChiTietDonHang__Get_All();
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);

            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);

            $objPHPExcel->getActiveSheet()->SetCellValue('A1', "MÃ ĐƠN");
            $objPHPExcel->getActiveSheet()->SetCellValue('B1', "HỌ TÊN");
            $objPHPExcel->getActiveSheet()->SetCellValue('C1', "SỐ ĐIỆN THOẠI");
            $objPHPExcel->getActiveSheet()->SetCellValue('D1', "NGÀY ĐẶT");
            $objPHPExcel->getActiveSheet()->SetCellValue('E1', "TỔNG TIỀN");
            $objPHPExcel->getActiveSheet()->SetCellValue('F1', ""); // Để tạo cột trống giữa thông tin đơn hàng và chi tiết sản phẩm

            $row_hd = 2; // Bắt đầu từ hàng thứ 2 để điền dữ liệu đơn hàng
            $row_sp = 3; // Bắt đầu từ hàng thứ 3 để điền dữ liệu sản phẩm

            foreach ($chiTietDonHang__Get_All as $item) {
                // Điền thông tin đơn hàng
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $row_hd, $item->madon);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $row_hd, $item->tenkh);
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $row_hd, $item->sdt);
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $row_hd, $item->sdt);
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $row_hd, $item->dongia);

                // Điền thông tin sản phẩm
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $row_hd, ""); // Tạo cột trống giữa thông tin đơn hàng và chi tiết sản phẩm
                $row_hd++;

                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $row_sp, $item->masp);
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $row_sp, $item->so_luong);
                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $row_sp, $item->don_gia);
                $row_sp++;

                // foreach ($item->masp as $sanpham) {
                //     $objPHPExcel->getActiveSheet()->SetCellValue('F' . $row_sp, $sanpham->ten_sanpham);
                //     $objPHPExcel->getActiveSheet()->SetCellValue('G' . $row_sp, $sanpham->so_luong);
                //     $objPHPExcel->getActiveSheet()->SetCellValue('H' . $row_sp, $sanpham->don_gia);
                //     $row_sp++;
                // }
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
