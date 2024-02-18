<?php
require_once '../model/SanPhamModel.php';
require_once '../model/AnhSpModel.php';
// require_once '../model/CommonModel.php';
$sp = new SanPhamModel();
// $anhSp = new AnhSpModel();
// $cm = new CommonModel();
$sp__Get_Top_Updated_5 = $sp->SanPham__Get_Top_Updated(5);
$sp__Get_Top_Updated_8 = $sp->SanPham__Get_Top_Updated(8);
// $sp__Get_Top_Sale = $sp->SanPham__Get_Top_Sale();
// $sp__Get_Top_Random = $sp->SanPham__Get_Top_Random(5);

$top = 0;
?>
<main class="main">

    <div class="main-container">
        <div class="main-title-container">
            <a href="index.php?pages=sp-moi&page=1">
                <div class="item-title color-1"><i class='bx bx-star bx-tada'></i>MỚI CẬP NHẬT</div>
            </a>
        </div>

    </div>

</main>