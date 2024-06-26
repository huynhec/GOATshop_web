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
        /* display: flex;
        flex-wrap: nowrap; */
        /* margin: 0 186px; */
        padding: 0;
        overflow-x: auto;
        scroll-behavior: smooth;
    }

    .product-details_view {
        width: 95%;
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

    .view-buy-now {

        background-color: #ffffff;
        color: #000;
        border: 2px solid #000000;
        padding: 10px 20px;
        font-size: 16px;
        width: 100%;
        cursor: pointer;
        font-weight: bold;
        /* border: none; */
    }
</style>

<div class="product-container_view">
    <div class="product-details_view">
        <h1><?= $sp__Get_By_Id->tensp ?></h1>
        <p class="brand">Thương hiệu: <?= ($th->ThuongHieu__Get_By_Id($sp__Get_By_Id->math))->tenth ?> | </p>
        <!-- <p class="brand"> Loại: Giày sân cỏ tự nhiên - Firm Ground</p> -->
        <p class="price"><?= number_format($dg->ShowDonGia__Get_By_Id_Spdg($masp)) ?>đ</p>
        <div class="size-selection">
            <div class="row">
                <h5 class="text-normal-view">Kích thước: </h5>
                <div>
                    <?php foreach ($size__Get_By_IdLoai as $item) : ?>
                        <?php if ($item->trangthai == 1) : ?>
                            <label class="size-option" id="size-label-<?= $item->idsize ?>" onclick="selectSize('<?= $item->idsize ?>')">
                                <input type="radio" name="size" id="idsize<?= $item->idsize ?>" value="<?= $item->tensize ?>">
                                <?= $item->tensize ?>
                            </label>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="product-size-hotline">
            <div class="product-hotline">
                <i class="fa fa-mobile" aria-hidden="true"></i> Hotline &amp; Zalo hỗ trợ: 098 5259052 <a href="tel:"></a>
            </div>
        </div>
        <?php if ($makh != 0 && $makh > 0) : ?>
            <div class="view-actions">
                <button class="view-buy-now" onclick="buyNowView('<?= $masp ?>')">Mua ngay</button>
                <!-- <button class="add-to-cart" onclick="addCartSizeView('<?= $masp ?>')">Thêm vào giỏ</button> -->
            </div>
        <?php else : ?>
            <a href="../api_auth?pages=dang-nhap">

                <div class="view-actions">
                    <!-- <button class="buy-now" onclick="return checkLogin()">Mua ngay</button>
                    <button class="add-to-cart" onclick="return checkLogin()">Thêm vào giỏ</button> -->
                    <button class="view-buy-now">Mua ngay</button>
                    <!-- <button class="add-to-cart">Thêm vào giỏ</button> -->
                </div>
            </a>
        <?php endif ?>

    </div>
</div>