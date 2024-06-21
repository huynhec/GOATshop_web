<?php
require_once '../../../model/SanPhamModel.php';
require_once '../../../model/AnhSpModel.php';
require_once '../../../model/CommonModel.php';
require_once '../../../model/DonGiaModel.php';
require_once '../../../model/SizeModel.php';
require_once '../../../model/ThuongHieuModel.php';

$th = new ThuongHieuModel();
$size = new SizeModel();
$dg = new DonGiaModel();
$sp = new SanPhamModel();
$anhSp = new AnhSpModel();
$cm = new CommonModel();

$masp = $_GET['masp'];
$maloai = $_GET['maloai'];
// $makh = isset($_SESSION['user']->makh) ? $_SESSION['user']->makh : 0;
$makh = $_GET['makh'] ?? 0;

$sp__Get_By_Id = $sp->SanPham__Get_By_Id($masp);
$sp__Get_By_IdLoai = $sp->SanPham__Get_By_IdLoai($maloai);
$size__Get_By_IdLoai = $size->Size__Get_By_Id_Loai($maloai);


$sp__Get_Top_Sale = $sp->SanPham__Get_Top_Sale();
$sp__Get_Top_Same = $sp->SanPham__Get_Top_Same($sp__Get_By_Id->math,  $masp);
$anhSp__Get_By_Id_Sp_Not_First = $anhSp->AnhSp__Get_By_Id_Sp_Not_First($sp__Get_By_Id->masp);
$anhSp__Get_By_Id_Sp_Thumbnail = $anhSp->AnhSp__Get_By_Id_Sp_Thumbnail($masp);
?>
<style>
    .product-container_view {
        display: flex;
        flex-wrap: nowrap;
        /* margin: 0 186px; */
        padding: 0;
        overflow-x: auto;
        scroll-behavior: smooth;
    }

    .product-details_view {
        width: 45%;
        padding: 0;
    }

    .product-details_view h1 {
        font-size: 24px;
        margin-bottom: 10px;
        font-weight: bold;
        font-family: "Montserrat", sans-serif !important;
        text-align: left !important;
    }

    .product-details_view .brand {
        font-size: 16px;
        margin-bottom: 10px;
        filter: contrast(35%);
        text-align: left !important;
    }

    .product-details_view .price {
        font-size: 24px;
        color: #EB5833;
        margin-bottom: 10px;
        font-weight: bold;
        text-align: left !important;

    }

    .product-details_view .installment {
        font-size: 16px;
        margin-bottom: 10px;
    }

    .product-details_view .discount {
        font-size: 14px;
        margin-bottom: 10px;
    }

    .product-details_view .discount a {
        color: #007bff;
        text-decoration: none;
    }

    .product-details_view .features {
        list-style-type: none;
        padding-left: 10px;
        margin-bottom: 20px;
    }

    .product-details_view .features li {
        margin-bottom: 5px;
        list-style-type: disc;
        font-size: 18px;
        text-align: left !important;
        filter: contrast(10%);
    }

    .text-normal-view {
        text-align: left !important;
    }
</style>

<div class="product-container_view">
    <div class="product-images">
        <div class="thumbnail-images">
            <?php foreach ($anhSp__Get_By_Id_Sp_Not_First as $key => $item) : ?>
                <img src="../assets/<?= $item->hinhanh ?>" alt="" onclick="changeImage('../assets/<?= $item->hinhanh ?>')">
            <?php endforeach ?>

        </div>
        <div class="main-image">

            <img id="currentImage" src="../assets/<?= $anhSp__Get_By_Id_Sp_Thumbnail->hinhanh ?>" alt="" style=" height: 650px; width: 650px;">
        </div>
    </div>
   
</div>