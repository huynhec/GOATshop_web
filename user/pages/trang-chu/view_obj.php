<?php
require_once '../../../model/SanPhamModel.php';
require_once '../../../model/AnhSpModel.php';
require_once '../../../model/CommonModel.php';
require_once '../../../model/DonGiaModel.php';

$sp = new SanPhamModel();
$anhSp = new AnhSpModel();
$cm = new CommonModel();
$sp__Get_Top9_Attribute_1 = $sp->SanPham__Get_Top_Attribute_1(9);
$sp__Get_Top9_Attribute_2 = $sp->SanPham__Get_Top_Attribute_2(9);
$sp__Get_Top9_Attribute_3 = $sp->SanPham__Get_Top_Attribute_3(9);
$sp__Get_Top9_Attribute_4 = $sp->SanPham__Get_Top_Attribute_4(9);
$your_value = isset($_POST['your_value']) ? $_POST['your_value'] : '1';
$productArrays = [
    '1' => $sp__Get_Top9_Attribute_1,
    '2' => $sp__Get_Top9_Attribute_2,
    '3' => $sp__Get_Top9_Attribute_3,
    '4' => $sp__Get_Top9_Attribute_4
];
?>
<style>
    .current-price-view {
        color: #d9534f !important;
        font-weight: bold !important;
        font-size: larger;
    }
    .original-price{
        color: #AAAAAA !important;
    }
</style>
<div class="product-grid" id="product-grid">

    <?php
    function renderProducts($products, $anhSp)
    {
        $dg = new DonGiaModel();

        foreach ($products as $item) {
            $makh = isset($_POST['makh']) ? $_POST['makh'] : 0;

            $anhSp__Get_By_Id_Sp_First = $anhSp->AnhSp__Get_By_Id_Sp_First($item->masp);
    ?>
            <div class="product-card" data-masp="<?= $anhSp__Get_By_Id_Sp_First->masp ?>" onmouseenter="startTimer(this)" onmouseleave="endTimer()" onclick="endTimer()">
                <a href="index.php?pages=chi-tiet&masp=<?= $anhSp__Get_By_Id_Sp_First->masp ?>&maloai=<?= $item->maloai ?>">
                    <img src="../assets/<?= $anhSp__Get_By_Id_Sp_First->hinhanh ?>" loading="lazy" alt="">
                </a>
                <div class="product-info">
                    <h2><?= $item->tensp ?></h2>

                    <span class="current-price-view"><?= number_format($dg->ShowDonGia__Get_By_Id_Spdg($item->masp)) ?>₫</span>
                    <?php if (number_format($dg->ShowDonGia__Get_By_Id_Spdg($item->masp)) < number_format($dg->ShowDonGiaMax__Get_By_Id_Spdg($item->masp))) : ?>
                        <span class="original-price"><s><?= number_format($dg->ShowDonGiaMax__Get_By_Id_Spdg($item->masp)) ?>₫</s></span>
                    <?php endif ?>
                    <div class="product-actions text-center clearfix">
                        <div>
                            <button type="button" class="btnQuickView quick-view medium--hide small--hide" data-handle="/products/nike-mercurial-vapor-13-academy-tf-2" onclick="return views('<?= $item->masp ?>','<?= $item->maloai ?>','<?= $_SESSION['user']->makh ?? 0; ?>')">
                                <span><i class="fa fa-search-plus" aria-hidden="true"></i></span>
                            </button>
                            <button type="button" class="btnBuyNow buy-now medium--hide small--hide" data-id="1085955545" onclick="viewBuys('<?= $item->masp ?>','<?= $item->maloai ?>','<?= $makh ?>')"><span>Mua ngay</span></button>
                            <button type="button" class="btnAddToCart add-to-cart medium--hide small--hide" data-id="1085955545" onclick="viewCarts('<?= $item->masp ?>','<?= $item->maloai ?>','<?= $makh ?>')">
                                <span><i class="fa fa-cart-plus" aria-hidden="true"></i></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
    <?php
        }
    }

    if (array_key_exists($your_value, $productArrays)) {
        renderProducts($productArrays[$your_value], $anhSp);
    } else {
        renderProducts($sp__Get_Top9_Attribute_1, $anhSp);
    }
    ?>
    <script>
        function views(masp, maloai, makh) {
            $.ajax({
                url: './pages/trang-chu/view.php',
                type: 'GET',
                data: {
                    masp: masp,
                    maloai: maloai,
                    makh: makh
                },
                success: function(response) {
                    Swal.fire({
                        showCloseButton: true,
                        html: response
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        function viewBuys(masp, maloai, makh) {
            $.ajax({
                url: './pages/trang-chu/viewBuy.php',
                type: 'GET',
                data: {
                    masp: masp,
                    maloai: maloai,
                    makh: makh
                },
                success: function(response) {
                    Swal.fire({
                        showCloseButton: true,
                        html: response
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        function viewCarts(masp, maloai, makh) {
            $.ajax({
                url: './pages/trang-chu/viewCart.php',
                type: 'GET',
                data: {
                    masp: masp,
                    maloai: maloai,
                    makh: makh
                },
                success: function(response) {
                    Swal.fire({
                        showCloseButton: true,
                        html: response
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    </script>