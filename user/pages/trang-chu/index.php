<?php
require_once '../model/SanPhamModel.php';
require_once '../model/AnhSpModel.php';
require_once '../model/CommonModel.php';
require_once '../model/DonGiaModel.php';

$dg = new DonGiaModel();
$sp = new SanPhamModel();
$anhSp = new AnhSpModel();
$cm = new CommonModel();
$sp__Get_Top_Updated_5 = $sp->SanPham__Get_Top_Updated(6);
$sp__Get_Top_Updated_24 = $sp->SanPham__Get_Top_Updated(24);
$sp__Get_Top_Sale = $sp->SanPham__Get_Top_Sale();
$sp__Get_Top_Random = $sp->SanPham__Get_Top_Random(6);

$top = 0;
?>
<style>
    body {
        font-family: Arial, sans-serif;
    }

    .product-item {
        width: 219px;
        /* border: 1px solid #ddd; */
        padding: 16px;
        margin: 16px;
        /* box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05); */
    }

    .product-img img {
        width: 100%;
        height: auto;
        display: block;
        transition: transform 0.3s ease;
        /* max-height: 200px;   
        object-fit: contain;       */

    }

    .product-img img:hover {
        transform: scale(1.05);
        /* Phóng to lên 10% khi hover */
    }

    .product-tags {
        position: relative;
        top: -40px;
        left: 0;
    }

    .tag-saleoff {
        background: red;
        color: white;
        padding: 4px 8px;
        font-size: 14px;
    }

    .product-actions {
        margin-top: 10px;
    }

    .product-actions button {
        background: #333;
        color: white;
        border: none;
        padding: 5px 10px;
        margin: 4px;
        cursor: pointer;
        transition: transform 0.3s ease;
        /* Thêm hiệu ứng chuyển đổi mượt mà */
    }

    .product-actions button:hover {
        background: #000;
        transform: scale(1.1);
        /* Phóng to lên 10% khi hover */
    }

    .product-title a {
        text-decoration: none;
        color: #333;
        font-weight: bold;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
        height: 3em;
        /* Adjust height according to font-size and line-height */
        line-height: 1.5em;
        /* Adjust line-height for better visual appearance */
    }

    .product-price {
        font-size: 16px;
        margin: 8px 0;
    }

    .current-price {
        color: #d9534f;
        font-weight: bold;
    }

    .original-price {
        color: #aaa;
        text-decoration: line-through;
    }

    .fundiin__panel {
        font-size: 14px;
        color: #333;
    }

    /* css cho sản phẩm nổi bật */
    .container {
        width: 90%;
        margin: 0 auto;
    }

    h1 {
        text-align: center;
        margin-top: 20px;
        font-size: 2em;
    }

    .filter-buttons {
        display: flex;
        justify-content: center;
        margin: 20px 0;
    }

    .filter-buttons button {
        background-color: #000;
        color: #fff;
        border: none;
        padding: 15px 30px;
        margin: 0 10px;
        cursor: pointer;
    }

    .filter-buttons button:hover {
        background-color: #555;
    }

    .product-grid {
        /* display: flex;
        justify-content: flex-start;
        flex-wrap: wrap; */
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        align-items: center;
        justify-content: flex-start;
        /* margin: 50px; */
    }

    .product-card {
        flex: 0 0 30%;
        box-sizing: border-box;
        background-color: #fff;
        margin: 15px;
        padding: 10px;
        width: 30%;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .product-card img {
        max-width: 100%;
        height: auto;
        border-bottom: 1px solid #ddd;
        padding-bottom: 15px;
        transition: transform 0.3s ease;
    }

    .product-info {
        padding: 10px;
    }

    .product-info h2 {
        font-size: 1.2em;
        margin: 10px 0;

        text-decoration: none;
        color: #333;
        font-weight: bold;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
        height: 3em;
        line-height: 1.5em;
    }

    .product-info p {
        color: #666;
        margin: 5px 0;
    }

    .product-info span {
        color: #fff;
    }

    .product-card button {
        background-color: #000;
        color: #fff;
        border: none;
        padding: 10px 35px;
        cursor: pointer;
        margin-top: 10px;
    }

    .product-card button:hover {
        background-color: #555;
    }

    /* Hover Effects */
    .product-card:hover {
        /* transform: translateY(-10px); */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .product-card:hover img {
        transform: scale(1.02);
    }

    .product-card:hover .product-info h2 {
        color: #000;
    }

    /* nút xem tất cả */
    .block-button {
        display: inline-block;
        padding: 10px 20px;
        font-size: 16px;
        font-weight: bold;
        text-align: center;
        text-decoration: none;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-left: 85%;
        margin-top: 25px;
    }

    .block-button--outline-black {
        color: #000;
        background-color: transparent;
        border: 2px solid #000;
        position: relative;
        overflow: hidden;
        z-index: 1;
    }

    .block-button--outline-black::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #000;
        z-index: -1;
        transition: transform 0.3s ease;
        transform: scaleX(0);
        transform-origin: right;
    }

    .block-button--outline-black:hover::before {
        transform: scaleX(1);
        transform-origin: left;
    }

    .block-button--outline-black:hover {
        color: #fff;
    }

    .block-button--outline-black:active {
        transform: translateY(2px);
    }

    /* css cho sản phẩm random */
    .product-item-random {
        flex: 0 0 20%;
        /* Điều chỉnh phần trăm theo số lượng sản phẩm trong một hàng */
        box-sizing: border-box;
        margin: 10px;
        /* Điều chỉnh theo nhu cầu */
    }
</style>
<main class="main">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>

        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="../assets/images/banner_img.png" alt="First slide">
                <div class="carousel-caption d-none d-md-block">
                    <div class="slide-light-text"> Sắp ra mắt </div>
                    <div class="slide-bold-text">
                        NIKE PHÁT HÀNH BỘ SƯU TẬP GIÀY ĐÁ BÓNG MAD READY KHỞI ĐỘNG 2024
                    </div>
                    <div class="slide-btn">
                        <a href="index.php?pages=loai-sp" class="slide-btn2">MUA HÀNG</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="../assets/images/banner_img1.png" alt="Second slide">
                <div class="carousel-caption d-none d-md-block">
                    <div class="slide-light-text"> Sắp ra mắt </div>
                    <div class="slide-bold-text">
                        BỘ SƯU TẬP PUMA PHENOMENAL PACK
                    </div>
                    <div class="slide-btn">
                        <a href="index.php?pages=loai-sp" class="slide-btn2">MUA HÀNG</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="../assets/images/banner_img2.webp" alt="Third slide">
                <div class="carousel-caption d-none d-md-block">
                    <div class="slide-light-text"> Sắp ra mắt </div>
                    <div class="slide-bold-text">
                        BỘ SƯU TẬP ADIDAS SOLAR ENERGY PACK
                    </div>
                    <div class="slide-btn">
                        <a href="index.php?pages=loai-sp" class="slide-btn2">MUA HÀNG</a>
                    </div>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only"></span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only"></span>
        </a>
    </div>
    <div class="main-view-item-container">
        <div class="main-container">
            <div class="main-title-container">
                <a href="index.php?pages=sp-moi&page=1">
                    <div class="item-title color-2" style="font-weight: bold; font-size: 24px;">Sản phẩm khuyến mãi</div>
                </a>
            </div>
            <div class="main-item-container">
                <?php foreach ($sp__Get_Top_Updated_5 as $item) : ?>
                    <?php if (count($sp__Get_Top_Updated_5) > 0) : ?>
                        <?php $anhSp__Get_By_Id_Sp_First = $anhSp->AnhSp__Get_By_Id_Sp_First($item->masp); ?>
                        <?php if (isset($anhSp__Get_By_Id_Sp_First->masp)) : ?>
                            <div class="product-item" data-masp="<?= $anhSp__Get_By_Id_Sp_First->masp ?>" onmouseenter="startTimer(this)" onmouseleave="endTimer()" onclick="endTimer()">
                                <div class="product-normal">
                                    <div class="product-img">
                                        <a href="index.php?pages=chi-tiet&masp=<?= $anhSp__Get_By_Id_Sp_First->masp ?>&maloai=<?= $item->maloai ?>">
                                            <img src="../assets/<?= $anhSp__Get_By_Id_Sp_First->hinhanh ?>" loading="lazy">
                                        </a>
                                        <!-- khuyến mãi -->
                                        <!-- <div class="product-tags">
                                        <div class="tag-saleoff text-center">-23%</div>
                                    </div> -->
                                        <div class="product-actions text-center clearfix">
                                            <div>
                                                <button type="button" class="btnQuickView quick-view medium--hide small--hide" data-handle="/products/nike-mercurial-vapor-13-academy-tf-2">
                                                    <span><i class="fa fa-search-plus" aria-hidden="true"></i></span>
                                                </button>
                                                <button type="button" class="btnBuyNow buy-now medium--hide small--hide" data-id="1085955545"><span>Mua ngay</span></button>
                                                <button type="button" class="btnAddToCart add-to-cart medium--hide small--hide" data-id="1085955545">
                                                    <span><i class="fa fa-cart-plus" aria-hidden="true"></i></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-variants-info">
                                        <!-- <div class="product-variants-count">1 phiên bản màu sắc</div> -->
                                    </div>
                                    <div class="product-title">
                                        <a href="index.php?pages=chi-tiet&masp=<?= $anhSp__Get_By_Id_Sp_First->masp ?>&maloai=<?= $item->maloai ?>">
                                            <?= $item->tensp ?>
                                        </a>
                                    </div>
                                    <div class="product-price clearfix">
                                        <span class="current-price"><?= number_format($dg->ShowDonGia__Get_By_Id_Spdg($item->masp)) ?>₫</span>
                                        <span class="original-price"><s>1,750,000₫</s></span>
                                    </div>
                                    <!-- <div class="fundiin__block-render-ui__loop" data-fundiin-loop-product-price-origin="1350000">
                                    <div class="fundiin__wrapper">
                                        <div shop-data-origin-panel="">
                                            <span class="fundiin__panel">Trả sau <span data-origin-price="">675.000đ</span> x2 kỳ</span>
                                            <a class="fundiin__logo">
                                                <img src="https://assets.fundiin.vn/merchant/logo_transparent.png" width="70" height="40" style="object-fit: contain;height:40px;width:70px">
                                            </a>
                                        </div>
                                    </div>
                                </div> -->
                                </div>
                            </div>
                        <?php else : ?>
                        <?php endif ?>
                    <?php endif ?>
                <?php endforeach ?>
            </div>


            <div class="main-container">
                <div class="main-title-container">
                    <a href="index.php?pages=sp-moi&page=1">
                        <div class="item-title color-2" style="font-weight: bold; font-size: 24px;">Sản phẩm nổi bật</div>
                    </a>
                </div>
                <div class="container">
                    <div class="filter-buttons">
                        <button>Giày đế cỏ nhân tạo (TF)</button>
                        <button>Giày đế cỏ tự nhiên (FG)</button>
                        <button>Găng tay thủ môn</button>
                        <button>Phụ kiện bóng đá</button>
                    </div>
                    <div class="product-grid">
                        <?php foreach ($sp__Get_Top_Sale as $item) : ?>
                            <?php if (count($sp__Get_Top_Sale) > 0) : ?>
                                <?php $anhSp__Get_By_Id_Sp_First = $anhSp->AnhSp__Get_By_Id_Sp_First($item->masp); ?>
                                <?php if (isset($anhSp__Get_By_Id_Sp_First->masp)) : ?>
                                    <div class="product-card" data-masp="<?= $anhSp__Get_By_Id_Sp_First->masp ?>" onmouseenter="startTimer(this)" onmouseleave="endTimer()" onclick="endTimer()">
                                        <a href="index.php?pages=chi-tiet&masp=<?= $anhSp__Get_By_Id_Sp_First->masp ?>&maloai=<?= $item->maloai ?>">
                                            <img src="../assets/<?= $anhSp__Get_By_Id_Sp_First->hinhanh ?>" loading="lazy" alt="">
                                        </a>
                                        <div class="product-info">
                                            <h2><?= $item->tensp ?></h2>
                                            <p>Sắp mở bán</p>
                                            <div class="product-actions text-center clearfix">
                                                <div>
                                                    <button type="button" class="btnQuickView quick-view medium--hide small--hide" data-handle="/products/nike-mercurial-vapor-13-academy-tf-2">
                                                        <span><i class="fa fa-search-plus" aria-hidden="true"></i></span>
                                                    </button>
                                                    <button type="button" class="btnBuyNow buy-now medium--hide small--hide" data-id="1085955545"><span>Mua ngay</span></button>
                                                    <button type="button" class="btnAddToCart add-to-cart medium--hide small--hide" data-id="1085955545">
                                                        <span><i class="fa fa-cart-plus" aria-hidden="true"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <a href="index.php?pages=chi-tiet&masp=<?= $item->masp ?>&maloai=<?= $item->maloai ?>">
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
                    <button class="block-button block-button--outline-black">Xem tất cả</button>
                </div>

                <!-- <div class="main-container__right">
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
                                <a href="index.php?pages=chi-tiet&masp=<?= $item->masp ?>&maloai=<?= $item->maloai ?>">
                                    <div class="manga-container__right" id="top_<?= $top++ ?>">
                                        <div class="manga-thumbnail" data-masp="<?= $anhSp__Get_By_Id_Sp_First->masp ?>" onmouseenter="startTimer(this)" onmouseleave="endTimer()" onclick="endTimer()">
                                            <img src="../assets/<?= $anhSp__Get_By_Id_Sp_First->hinhanh ?>">
                                            <span class="manga-note background-7"> <b>Top <?= $top ?></b> |
                                                <?= $cm->formatThousand($item->luotmua) ?> lượt mua</span>
                                        </div>
                                        <div class="blur"></div>
                                        <div class="manga-title color-3"><?= $item->tensp ?></div>
                                    </div>
                                </a>
                            <?php endif ?>
                        <?php endif ?>
                    <?php endforeach ?>
                </div>
            </div> -->
            </div>

            <div class="main-container">
                <div class="main-title-container">
                    <a href="index.php?pages=sp-ngau-nhien">
                        <div class="item-title color-8"><i class='bx bx-book-reader'></i>HÔM NAY MUA GÌ?</div>
                    </a>
                </div>
                <!-- <div class="main-item-container"> -->
                <!-- <?php foreach ($sp__Get_Top_Random as $item) : ?>
                        <?php if (count($sp__Get_Top_Random) > 0) : ?>
                            <?php $anhSp__Get_By_Id_Sp_First = $anhSp->AnhSp__Get_By_Id_Sp_First($item->masp); ?>
                            <?php if (isset($anhSp__Get_By_Id_Sp_First->masp)) : ?>
                                <a href="index.php?pages=chi-tiet&masp=<?= $item->masp ?>&maloai=<?= $item->maloai ?>">
                                    <div class="manga-container" data-masp="<?= $anhSp__Get_By_Id_Sp_First->masp ?>" onmouseenter="startTimer(this)" onmouseleave="endTimer()" onclick="endTimer()">
                                        <div class="manga-thumbnail">
                                            <img src="../assets/<?= $anhSp__Get_By_Id_Sp_First->hinhanh ?>">
                                            <span class="manga-note background-8"><?= number_format($dg->ShowDonGia__Get_By_Id_Spdg($item->masp)) ?>₫</i></span>
                                        </div>
                                        <div class="manga-title color-8"><?= $item->tensp ?></div>
                                    </div>
                                </a>
                            <?php endif ?>
                        <?php endif ?>
                    <?php endforeach ?> -->
                <div class="product-slider">
                    <div class="product-container">
                        <!-- Products -->
                        <?php foreach ($sp__Get_Top_Updated_5 as $item) : ?>
                            <?php if (count($sp__Get_Top_Updated_5) > 0) : ?>
                                <?php $anhSp__Get_By_Id_Sp_First = $anhSp->AnhSp__Get_By_Id_Sp_First($item->masp); ?>
                                <?php if (isset($anhSp__Get_By_Id_Sp_First->masp)) : ?>
                                    <div class="product-item-random" data-masp="<?= $anhSp__Get_By_Id_Sp_First->masp ?>" onmouseenter="startTimer(this)" onmouseleave="endTimer()" onclick="endTimer()">
                                        <div class="product-normal">
                                            <div class="product-img">
                                                <a href="index.php?pages=chi-tiet&masp=<?= $anhSp__Get_By_Id_Sp_First->masp ?>&maloai=<?= $item->maloai ?>">
                                                    <img src="../assets/<?= $anhSp__Get_By_Id_Sp_First->hinhanh ?>" loading="lazy">
                                                </a>
                                            </div>
                                            <div class="product-title">
                                                <a href="index.php?pages=chi-tiet&masp=<?= $anhSp__Get_By_Id_Sp_First->masp ?>&maloai=<?= $item->maloai ?>">
                                                    <?= $item->tensp ?>
                                                </a>
                                            </div>
                                            <div class="product-price clearfix">
                                                <span class="current-price"><?= number_format($dg->ShowDonGia__Get_By_Id_Spdg($item->masp)) ?>₫</span>
                                                <span class="original-price"><s>1,750,000₫</s></span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif ?>
                            <?php endif ?>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>

</main>

<script>
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;
                    console.log("Latitude:", latitude);
                    console.log("Longitude:", longitude);
                    reverseGeocodingWithGoogle(latitude, longitude);
                },
                (error) => {
                    console.log("Error getting location:", error);
                }
            );
        } else {
            console.log("Geolocation is not supported by this browser.");
        }
    }

    function reverseGeocodingWithGoogle(latitude, longitude) {
        fetch(`https://maps.googleapis.com/maps/api/geocode/json?latlng=${latitude},${longitude}&key=AIzaSyBWzRuWS-rxMCENShE23x4Gh1f7R3vAL1Y`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.results && data.results.length > 0) {
                    console.log("User's Location Info: ", data.results[0]);
                } else {
                    console.log("No location information found.");
                }
            })
            .catch(error => {
                console.error('Error fetching geolocation data:', error);
            });
    }

    // Call the getLocation function when the page is loaded
    getLocation();
</script>