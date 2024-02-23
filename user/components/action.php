<?php
session_start();
require_once "../../model/GioHangModel.php";
require_once "../../model/ChiTietGioHangModel.php";
require_once "../../model/DonHangModel.php";
require_once "../../model/ChiTietDonHangModel.php";
require_once "../../model/KhachHangModel.php";
require_once "../../model/SanPhamModel.php";
require_once "../../model/SizeModel.php";
require_once "../../model/SizeSpModel.php";

$kh = new KhachHangModel();
$gh = new GioHangModel();
$ctgh = new ChiTietGioHangModel();
$dh = new DonHangModel();
$ctdh = new ChiTietDonHangModel();
$sp = new SanPhamModel();
$sz = new SizeModel();
$szsp = new SizeSpModel();
if (isset($_POST['action'])) {
    // Xử lý dựa trên action
    switch ($_POST['action']) {
        case 'delete':

            $madon = $_POST['madon'];
            $res = $dh->DonHang__Delete($madon);

            echo $res;
            break;

        case 'checkout':
            $makh = $_POST['makh'];
            $tenkh = $_POST['tenkh'];
            $diachi = $_POST['diachi'];
            $sodienthoai = $_POST['sodienthoai'];
            $email = $_POST['email'];
            $magh = $_POST['magh'];

            // cập nhật thông tin khách hàng (vì giữ cái liên kết khóa ngoại ở đơn hàng)
            $khRes = $kh->KhachHang__Update_Info($makh, $tenkh, $sodienthoai, $diachi, $email);
            $resKh = $kh->KhachHang__Get_By_Id($makh);
            $_SESSION['user'] = $resKh;
            // Thêm đơn hàng
            $ngaythem = Date('Y-m-d H:i:s');
            $tongdh = $ctgh->ChiTietGioHang__Sum_Tien_GH($magh)->sum_tien;
            $madh = $dh->DonHang__Add($ngaythem, $makh, $tongdh);

            // Lấy thông tin giỏ hàng
            $ctghRes = $ctgh->ChiTietGioHang__Get_By_Id_GH($magh);
            foreach ($ctghRes as $item) {
                $masp = $item->masp;
                $soluong = $item->soluong;
                $dongia = $item->dongia;
                $masize = $item->masize;
                $luotmua = $sp->SanPham__Get_By_Id($masp)->luotmua + 1;
                // Thêm chi tiết đơn hàng
                $resDh = $ctdh->ChiTietDonHang__Add($madh, $masp, $soluong, $dongia, $masize);
                $resSp = $sp->SanPham__Update_Luot_Mua($masp, $luotmua);
            }
            $res = $gh->GioHang__Update_Trang_Thai($magh, 0);
            if ($res > 0) {
                echo true;
            } else {
                echo false;
            }
            break;
        case 'add':
            error_reporting(E_ALL);
            ini_set('display_errors', 1);



            $masp = $_POST['masp'];
            $soluong =  1;
            $dongia = $sp->SanPham__Get_By_Id($masp)->dongia;
            $ngaythem = date('Y-m-d H:i:s');
            $makh = $_SESSION['user']->makh;
            $trangthai = 1; //giỏ hàng đang được tạo, chưa thêm vào đơn hàng

            $masize = $_POST['masize'];
            
            $resGH = $gh->GioHang__Get_By_Id_Kh($makh);
            if (isset($resGH->magh)) {
                $check = $ctgh->ChiTietGioHang__Check($resGH->magh, $masp, $makh, $masize);
                if ($check != false) {
                    $resCtgh = $ctgh->ChiTietGioHang__Update($check->mactgh, $check->magh, $masp, $check->soluong + 1, $dongia);
                    $res = $szsp->SizeSp__Add($masp, $masize);

                } else {
                    $resCtgh = $ctgh->ChiTietGioHang__Add($resGH->magh, $masp, $soluong, $dongia, $masize);
                    $res = $szsp->SizeSp__Add($masp, $masize);

                }
            } else {
                $magh = $gh->GioHang__Add($ngaythem, $makh, $trangthai);
                $resCtgh = $ctgh->ChiTietGioHang__Add($magh, $masp, $soluong, $dongia, $masize);
                $res = $szsp->SizeSp__Add($masp, $masize);
            }

            $maghNew = $gh->GioHang__Get_By_Id_Kh($makh);
            $res = $ctgh->ChiTietGioHang__Get_By_Id_GH($maghNew->magh);
            echo count($res);
            break;

        case 'remove':

            $mactgh = $_POST['mactgh'];
            $res = $ctgh->ChiTietGioHang__Delete($mactgh);
            if (isset($ctgh->ChiTietGioHang__Get_By_Id($mactgh)->magh)) {
                $magh = $ctgh->ChiTietGioHang__Get_By_Id($mactgh)->magh;
                $resMagh = $gh->GioHang__Get_By_Id($magh);
                if (count($resMagh) > 0) {
                    $resGH = $gh->GioHang__Delete($magh);
                }
            }
            echo $res;
            break;
        case 'update':

            $mactgh = $_POST['mactgh'];
            $magh = $_POST['magh'];
            $masp = $_POST['masp'];
            $soluong = $_POST['soluong'];
            $dongia = $_POST['dongia'];

            $res = $ctgh->ChiTietGioHang__Update($mactgh, $magh, $masp, $soluong, $dongia);
            $sum = $ctgh->ChiTietGioHang__Sum_Tien_GH($magh)->sum_tien;
            if ($res > 0) {
                $soluongmoi = $ctgh->ChiTietGioHang__Get_By_Id($mactgh)->soluong;
                echo json_encode([
                    "soluong" => $soluongmoi,
                    "tongcong" => number_format($soluongmoi * $dongia),
                    "sum" => number_format($sum),
                ]);
            } else {
                echo json_encode([
                    "soluong" => $soluong,
                    "tongcong" => number_format($soluong * $dongia),
                    "sum" => number_format($sum),
                ]);
            }
            break;

    }
}
