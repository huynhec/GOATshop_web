<?php
require_once '../model/SanPhamModel.php';
require_once '../model/AnhSpModel.php';
require_once '../model/CommonModel.php';
$sp = new SanPhamModel();
$anhSp = new AnhSpModel();
$cm = new CommonModel();
$sp__Get_Top_Updated_5 = $sp->SanPham__Get_Top_Updated(5);
$sp__Get_Top_Updated_8 = $sp->SanPham__Get_Top_Updated(8);
// $sp__Get_Top_Sale = $sp->SanPham__Get_Top_Sale();
$sp__Get_Top_Random = $sp->SanPham__Get_Top_Random(5);

$top = 0;
?>
<main class="main">

    <div class="main-container">
        <div class="main-title-container">
            <a href="index.php?pages=sp-moi&page=1">
                <div class="item-title color-1"><i class='bx bx-star bx-tada'></i>MỚI CẬP NHẬT</div>
            </a>
        </div>
        <div class="main-item-container">
            <?php foreach ($sp__Get_Top_Updated_5 as $item) : ?>
            <?php if (count($sp__Get_Top_Updated_5) > 0) : ?>
            <?php $anhSp__Get_By_Id_Sp_First = $anhSp->AnhSp__Get_By_Id_Sp_First($item->masp); ?>
            <?php if (isset($anhSp__Get_By_Id_Sp_First->masp)) : ?>
            <a href="index.php?pages=chi-tiet&masp=<?= $anhSp__Get_By_Id_Sp_First->masp ?>">
                <div class="manga-container">
                    <div class="manga-thumbnail">
                        <img src="../assets/<?= $anhSp__Get_By_Id_Sp_First->hinhanh ?>">
                        <span class="manga-note background-1"><i
                                class="bx bxs-badge-dollar"></i><?=$cm->getTimeAgo($item->ngaythem)?></span>                    </div>
                    <div class="manga-title color-1"><?= $item->tensp ?></div>
                </div>
            </a>
            <?php else : ?>
            <a href="index.php?pages=chi-tiet&masp=<?= $item->masp ?>">
                <div class="manga-container">
                    <div class="manga-thumbnail">
                        <img src="../assets/<?= $item->hinhanh ?>">
                        <span class="manga-note background-1">Đang cập nhật... <i class="bx bxs-star"></i></span>
                    </div>
                    <div class="manga-title color-1"><?= $item->tensp ?></div>
                </div>
            </a>
            <?php endif ?>
            <?php endif ?>
            <?php endforeach ?>


        </div>
    </div>

    <div class="main-container">
        <div class="main-container__left">
            <div class="main-title-container__left">
                <a href="index.php?pages=sp-manga">
                    <div class="item-title color-2"><i class='bx bx-star bx-tada'></i>Sản phẩm chất lượng</div>
                </a>
            </div>
            <div class="main-item-container__left">
                <?php foreach ($sp__Get_Top_Updated_8 as $item) : ?>
                <?php if (count($sp__Get_Top_Updated_8) > 0) : ?>
                <?php $anhSp__Get_By_Id_Sp_First = $anhSp->AnhSp__Get_By_Id_Sp_First($item->masp); ?>
                <?php if (isset($anhSp__Get_By_Id_Sp_First->masp)) : ?>
                <a href="index.php?pages=chi-tiet&masp=<?= $anhSp__Get_By_Id_Sp_First->masp ?>">
                    <div class="manga-container">
                        <div class="manga-thumbnail">
                            <img src="../assets/<?= $anhSp__Get_By_Id_Sp_First->hinhanh ?>">
                            <span class="manga-note background-1"><i
                                    class="bx bxs-badge-dollar"></i><?=number_format($item->dongia)?>đ</span>
                        </div>
                        <div class="manga-title color-1"><?= $item->tensp ?></div>
                    </div>
                </a>
                <?php else : ?>
                <a href="index.php?pages=chi-tiet&masp=<?= $item->masp ?>">
                    <div class="manga-container">
                        <div class="manga-thumbnail">
                            <img src="../assets/<?= $item->hinhanh ?>">
                            <span class="manga-note background-1">Đang cập nhật... <i class="bx bxs-star"></i></span>
                        </div>
                        <div class="manga-title color-1"><?= $item->tensp ?></div>
                    </div>
                </a>
                <?php endif ?>
                <?php endif ?>
                <?php endforeach ?>
            </div>
        </div>

        <div class="main-container__right">
            <div class="main-title-container__right">
                <a href="index.php?pages=sp-top">
                    <div class="item-title color-3"><i class='bx bx-star bx-tada'></i>TOP BÁN CHẠY</div>
                </a>
            </div>
            <div class="main-item-container__right">
                <?php foreach ($sp__Get_Top_Sale as $item) : ?>
                <?php if (count($sp__Get_Top_Sale) > 0) : ?>
                <?php $anhSp__Get_By_Id_Sp_First = $anhSp->AnhSp__Get_By_Id_Sp_First($item->masp); ?>
                <?php if (isset($anhSp__Get_By_Id_Sp_First->masp)) : ?>
                <a href="index.php?pages=chi-tiet&masp=<?= $item->masp ?>">
                    <div class="manga-container__right" id="top_<?= $top++ ?>">
                        <div class="manga-thumbnail">
                            <img src="../assets/<?= $anhSp__Get_By_Id_Sp_First->hinhanh ?>">
                            <span class="manga-note background-1"><i
                                    class="bx bxs-badge-dollar"></i><?=number_format($item->dongia)?>đ</span>                        </div>
                        <div class="blur"></div>
                        <div class="manga-title color-3"><?= $item->tensp ?></div>
                    </div>
                </a>
                <?php endif ?>
                <?php endif ?>
                <?php endforeach ?>
            </div>
        </div>
    </div>

    <div class="main-container">
        <div class="main-title-container">
            <a href="index.php?pages=sp-ngau-nhien">
                <div class="item-title color-8"><i class='bx bx-book-reader'></i>HÔM NAY MUA GÌ?</div>
            </a>
        </div>
        <div class="main-item-container">
            <?php foreach ($sp__Get_Top_Random as $item) : ?>
            <?php if (count($sp__Get_Top_Random) > 0) : ?>
            <?php $anhSp__Get_By_Id_Sp_First = $anhSp->AnhSp__Get_By_Id_Sp_First($item->masp); ?>
            <?php if (isset($anhSp__Get_By_Id_Sp_First->masp)) : ?>
            <a href="index.php?pages=chi-tiet&masp=<?= $item->masp ?>">
                <div class="manga-container">
                    <div class="manga-thumbnail">
                        <img src="../assets/<?= $anhSp__Get_By_Id_Sp_First->hinhanh ?>">
                        <span class="manga-note background-8"><?= number_format($item->dongia) ?>đ</i></span>
                    </div>
                    <div class="manga-title color-8"><?= $item->tensp ?></div>
                </div>
            </a>
            <?php endif ?>
            <?php endif ?>
            <?php endforeach ?>
        </div>
    </div>
</main>