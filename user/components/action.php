<?php
session_start();
require_once "../../model/GioHangModel.php";
require_once "../../model/ChiTietGioHangModel.php";
require_once "../../model/DonHangModel.php";
require_once "../../model/ChiTietDonHangModel.php";
require_once "../../model/KhachHangModel.php";
require_once "../../model/SanPhamModel.php";
require_once "../../model/SizeModel.php";
require_once "../../model/TimeTrackingModel.php";
require_once "../../model/LuotXemModel.php";
require_once "../../model/DonGiaModel.php";
require_once "../../model/DiaChiModel.php";
require_once '../../model/ChiTietTrangThaiModel.php';
$cttt = new ChiTietTrangThaiModel();
$kh = new KhachHangModel();
$gh = new GioHangModel();
$ctgh = new ChiTietGioHangModel();
$dh = new DonHangModel();
$ctdh = new ChiTietDonHangModel();
$sp = new SanPhamModel();
$sz = new SizeModel();
$ttr = new TimeTrackingModel();
$lx = new LuotXemModel();
$dg = new DonGiaModel();
$dc = new DiaChiModel();

if (isset($_POST['action'])) {
    // Xử lý dựa trên action
    switch ($_POST['action']) {

        case 'delete':
            $res = 0;
            $madon = $_POST['madon'];
            $matt = 8;
            $manv = null;
            $ngaytao = date('Y-m-d H:i:s');
            $res += $cttt->ChiTietTrangThai__Add($madon, $matt, $manv, $ngaytao);
            // cập nhật trạng thái đơn hàng
            $trangthai = 0;
            $dh->DonHang__Update_State($madon, $trangthai);
            if ($res != 0) {
                echo true;
            } else {
                echo false;
            }

            break;

        case 'checkout':
            $makh = $_POST['makh'];
            $tenkh = $_POST['tenkh'];
            $payment_method = $_POST['payment_method'];
            $shipping_method = $_POST['shipping_method'];
            //địa chỉ
            if (isset($_POST['diachi'])) {
                $diachi_parts = explode(', ', $_POST['diachi']);
                $tinh = $diachi_parts[0]; // "Hà Nội"
                $huyen = $diachi_parts[1]; // "Ba Đình"
                $xa = $diachi_parts[2]; // "Kim Mã"
                $road = $diachi_parts[3]; // "123 đường ABC"

                $diachi_add = $dc->DiaChi__Add($makh, $tinh, $huyen, $xa, $road);
            }

            $diachi__Get_By_Id_Kh = $dc->DiaChi__Get_By_Id_Kh($makh);
            $diachi_id = $diachi__Get_By_Id_Kh->diachi_id;

            $sodienthoai = $_POST['sodienthoai'];
            $email = $_POST['email'];
            $magh = $_POST['magh'];
            $username = $_POST['username'];
            // cập nhật thông tin khách hàng (vì giữ cái liên kết khóa ngoại ở đơn hàng)
            // $khRes = $kh->KhachHang__Update_Info($makh, $tenkh, $sodienthoai, $email);
            $resKh = $kh->KhachHang__Get_By_Id($makh);
            $_SESSION['user'] = $resKh;
            // Thêm đơn hàng
            $ngaythem = Date('Y-m-d H:i:s');
            $tongdh = $ctgh->ChiTietGioHang__Sum_Tien_GH($magh)->sum_tien;
            $madh = $dh->DonHang__Add($ngaythem, $makh, $diachi_id, $tongdh);

            // Lấy thông tin giỏ hàng
            $ctghRes = $ctgh->ChiTietGioHang__Get_By_Id_GH($magh);
            foreach ($ctghRes as $item) {
                $masp = $item->masp;
                $soluong = $item->soluong;
                $dongia = $item->dongia;
                $idsize = $item->idsize;
                $luotmua = $sp->SanPham__Get_By_Id($masp)->luotmua + 1;
                // Thêm chi tiết đơn hàng
                $resDh = $ctdh->ChiTietDonHang__Add($madh, $masp, $soluong, $dongia, $idsize, $tenkh, $sodienthoai);
                $resSp = $sp->SanPham__Update_Luot_Mua($masp, $luotmua);
            }

            // cập nhật trạng thái 
            $matt = 0;
            $manv = null;
            $ngaytao = date('Y-m-d H:i:s');

            $res = $cttt->ChiTietTrangThai__Add($madh, $matt, $manv, $ngaytao);
            $res1 = $gh->GioHang__Update_Trang_Thai($magh, 0);
            $madon = $madh;
            $total = $dh->DonHang__Get_By_Id($madon)->tongdh + $shipping_method;
            $total_amount = $total;
            if ($payment_method == 'bank_transfer') {
                // echo json_encode(['success' => true, 'payment_method' => 'bank_transfer', 'madon' => $madon]);
                echo json_encode(['success' => true, 'payment_method' => 'bank_transfer', 'madon' => $madon, 'total_amount' => $total_amount]);
            } else {
                echo json_encode(['success' => true, 'payment_method' => 'cod']);
            }
            break;
        case 'add':
            error_reporting(E_ALL);
            ini_set('display_errors', 1);

            $masp = $_POST['masp'];
            $soluong =  1;
            $dongia = $dg->ShowDonGia__Get_By_Id_Spdg($masp);
            $ngaythem = date('Y-m-d H:i:s');
            $makh = $_SESSION['user']->makh;
            $trangthai = 1; //giỏ hàng đang được tạo, chưa thêm vào đơn hàng
            $idsize = $_POST['idsize'] ?? 0;

            $resGH = $gh->GioHang__Get_By_Id_Kh($makh);
            if (isset($resGH->magh)) {
                $check = $ctgh->ChiTietGioHang__Check($resGH->magh, $masp, $makh, $idsize);
                if ($check != false) {
                    $res = $ctgh->ChiTietGioHang__Update($check->mactgh, $check->magh, $masp, $check->soluong + 1, $dongia);
                } else {
                    $res = $ctgh->ChiTietGioHang__Add($resGH->magh, $masp, $soluong, $dongia, $idsize);
                }
            } else {
                $magh = $gh->GioHang__Add($ngaythem, $makh, $trangthai);
                $res = $ctgh->ChiTietGioHang__Add($magh, $masp, $soluong, $dongia, $idsize);
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
        case 'view':
            $masp = isset($_POST['masp']) ? intval($_POST['masp']) : 0;
            $makh = $_POST['makh'];
            $newViewCount = $lx->LuotXem__Add($masp, $makh);

            echo number_format($newViewCount);
            break;
        case "timetracking":
            $res = 0;
            $typetrack = $_POST['typetrack'];
            $masp = $_POST['masp'];
            $makh = $_POST['makh'];
            $timeCounter = $_POST['timeCounter'];
            $ngay = date('Y-m-d');
            // Kiểm tra và xử lý tính toán của $typetrack
            if ($typetrack == 1) {
                $timeCounter = $timeCounter * 2;
            }
            $res += $ttr->User_item_tracking__Add($timeCounter, $masp, $makh, $typetrack, $ngay);
            // if ($res != 0) {
            //     header('location: ../../index.php?pages=thoi-gian-theo-doi&msg=success');
            // } else {
            //     header('location: ../../index.php?pages=thoi-gian-theo-doi&msg=error');
            // }
            break;
    }
}
