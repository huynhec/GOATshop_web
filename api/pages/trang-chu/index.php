<?php
require_once '../model/SanPhamModel.php';
require_once '../model/AnhSpModel.php';
require_once '../model/CommonModel.php';
require_once '../model/DonGiaModel.php';
require_once '../model/GoiYModel.php';
require_once '../model/BannerModel.php';

$dg = new DonGiaModel();
$sp = new SanPhamModel();
$anhSp = new AnhSpModel();
$cm = new CommonModel();
$gy = new GoiYModel();
$bn = new BannerModel();

$makh = isset($_SESSION['user']->makh) ? $_SESSION['user']->makh : 0;

$sp__Get_Top_Updated_5 = $sp->SanPham__Get_Top_Updated(6);
$sp__Get_Top_Updated_24 = $sp->SanPham__Get_Top_Updated(24);
$sp__Get_Top_Sale = $sp->SanPham__Get_Top_Sale();
$sp__Get_Top_Random = $sp->SanPham__Get_Top_Random(6);
$goi_Y_User_Based = $gy->Goi_Y_User_Based($makh);
$banner__Show = $bn->Banner__Show();
$sanPham__Get_Khuyenmai = $sp->SanPham__Get_Khuyenmai();

$top = 0;
?>

<main class="main">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <?php $count = 0; ?>
            <?php foreach ($banner__Show as $item) : ?>
                <li data-target="#carouselExampleIndicators" data-slide-to="<?= $count++ ?>"></li>
            <?php endforeach ?>

        </ol>

        <div class="carousel-inner">
            <?php foreach ($banner__Show as $item) : ?>
                <div class="carousel-item">
                    <img class="d-block w-100" src="../assets/<?= $item->anhbanner ?>" alt="First slide">
                    <div class="carousel-caption d-none d-md-block">
                        <div class="slide-light-text"> Sắp ra mắt </div>
                        <div class="slide-bold-text">
                            <?= $item->tenbanner ?>
                        </div>
                        <div class="slide-btn">
                            <a href="index.php?pages=loai-sp" class="slide-btn2">XEM SẢN PHẨM</a>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
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
            <?php if (isset($_SESSION['user']) && count($goi_Y_User_Based) > 0) : ?>
                <div class="main-title-container">
                    <a href="index.php?pages=sp-moi&page=1">
                        <div class="item-title">Dành riêng cho bạn!
                        </div>
                    </a>
                </div>
                <div class="main-item-container" style="background-color:beige;">
                    <?php foreach ($goi_Y_User_Based as $item) : ?>
                        <?php if (count($goi_Y_User_Based) > 0) : ?>
                            <?php $anhSp__Get_By_Id_Sp_First = $anhSp->AnhSp__Get_By_Id_Sp_First($item->masp); ?>
                            <?php if (isset($anhSp__Get_By_Id_Sp_First->masp)) : ?>
                                <div class="product-item" data-masp="<?= $anhSp__Get_By_Id_Sp_First->masp ?>" onmouseenter="startTimer(this)" onmouseleave="endTimer()" onclick="endTimer()">
                                    <div class="product-normal">
                                        <div class="product-img">
                                            <a href="index.php?pages=chi-tiet&masp=<?= $anhSp__Get_By_Id_Sp_First->masp ?>&maloai=<?= $item->maloai ?>">
                                                <img src="../assets/<?= $anhSp__Get_By_Id_Sp_First->hinhanh ?>" loading="lazy">
                                            </a>
                                            <!-- khuyến mãi -->
                                            <?php
                                            $min = $dg->ShowDonGia__Get_By_Id_Spdg($item->masp);
                                            $max = $dg->ShowDonGiaMax__Get_By_Id_Spdg($item->masp);
                                            $res = (($max - $min) / $max) * 100;
                                            $rounded_res = round($res, 0); // Làm tròn đến 2 chữ số thập phân
                                            ?>
                                            <?php if ($rounded_res > 0) : ?>
                                                <div class="product-tags">
                                                    <div class="tag-saleoff text-center">-<?= $rounded_res ?>%</div>
                                                </div>
                                            <?php endif ?>
                                            <div class="product-actions text-center clearfix">
                                                <div>
                                                    <button type="button" class="btnQuickView quick-view medium--hide small--hide" onclick="return view('<?= $item->masp ?>','<?= $item->maloai ?>','<?= $_SESSION['user']->makh ?? 0; ?>')">
                                                        <span><i class="fa fa-search-plus" aria-hidden="true"></i></span>
                                                    </button>
                                                    <button type="button" class="btnBuyNow buy-now medium--hide small--hide" data-id="1085955545" onclick="viewBuy('<?= $item->masp ?>','<?= $item->maloai ?>','<?= $_SESSION['user']->makh ?? 0; ?>')"><span>Mua ngay</span></button>
                                                    <button type="button" class="btnAddToCart add-to-cart medium--hide small--hide" data-id="1085955545" onclick="viewCart('<?= $item->masp ?>','<?= $item->maloai ?>','<?= $_SESSION['user']->makh ?? 0; ?>')">
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
                                            <?php if (number_format($dg->ShowDonGia__Get_By_Id_Spdg($item->masp)) < number_format($dg->ShowDonGiaMax__Get_By_Id_Spdg($item->masp))) : ?>
                                                <span class="original-price"><s><?= number_format($dg->ShowDonGiaMax__Get_By_Id_Spdg($item->masp)) ?>₫</s></span>
                                            <?php endif ?>
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
            <?php endif; ?>
            <div class="main-title-container">
                <a href="index.php?pages=khuyen-mai">
                    <div class="item-title">Sản phẩm khuyến mãi
                    </div>
                </a>
            </div>
            <div class="main-item-container" style="background-color:bisque;">
                <?php foreach ($sanPham__Get_Khuyenmai as $item) : ?>
                    <?php if (count($sanPham__Get_Khuyenmai) > 0) : ?>
                        <?php $anhSp__Get_By_Id_Sp_First = $anhSp->AnhSp__Get_By_Id_Sp_First($item->masp); ?>
                        <?php if (isset($anhSp__Get_By_Id_Sp_First->masp)) : ?>
                            <div class="product-item" data-masp="<?= $anhSp__Get_By_Id_Sp_First->masp ?>" onmouseenter="startTimer(this)" onmouseleave="endTimer()" onclick="endTimer()">
                                <div class="product-normal">
                                    <div class="product-img">
                                        <a href="index.php?pages=chi-tiet&masp=<?= $anhSp__Get_By_Id_Sp_First->masp ?>&maloai=<?= $item->maloai ?>">
                                            <img src="../assets/<?= $anhSp__Get_By_Id_Sp_First->hinhanh ?>" loading="lazy">
                                        </a>
                                        <!-- khuyến mãi -->
                                        <?php
                                        $min = $dg->ShowDonGia__Get_By_Id_Spdg($item->masp);
                                        $max = $dg->ShowDonGiaMax__Get_By_Id_Spdg($item->masp);
                                        $res = (($max - $min) / $max) * 100;
                                        $rounded_res = round($res, 0); // Làm tròn đến 2 chữ số thập phân
                                        ?>
                                        <?php if ($rounded_res > 0) : ?>
                                            <div class="product-tags">
                                                <div class="tag-saleoff text-center">-<?= $rounded_res ?>%</div>
                                            </div>
                                        <?php endif ?>
                                        <div class="product-actions text-center clearfix">
                                            <div>
                                                <button type="button" class="btnQuickView quick-view medium--hide small--hide" data-handle="/products/nike-mercurial-vapor-13-academy-tf-2" onclick="return view('<?= $item->masp ?>','<?= $item->maloai ?>','<?= $_SESSION['user']->makh ?? 0; ?>')">
                                                    <span><i class="fa fa-search-plus" aria-hidden="true"></i></span>
                                                </button>
                                                <button type="button" class="btnBuyNow buy-now medium--hide small--hide" data-id="1085955545" onclick="viewBuy('<?= $item->masp ?>','<?= $item->maloai ?>','<?= $_SESSION['user']->makh ?? 0; ?>')"><span>Mua ngay</span></button>
                                                <button type="button" class="btnAddToCart add-to-cart medium--hide small--hide" data-id="1085955545" onclick="viewCart('<?= $item->masp ?>','<?= $item->maloai ?>','<?= $_SESSION['user']->makh ?? 0; ?>')">
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
                                        <?php if (number_format($dg->ShowDonGia__Get_By_Id_Spdg($item->masp)) < number_format($dg->ShowDonGiaMax__Get_By_Id_Spdg($item->masp))) : ?>
                                            <span class="original-price"><s><?= number_format($dg->ShowDonGiaMax__Get_By_Id_Spdg($item->masp)) ?>₫</s></span>
                                        <?php endif ?>

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
                    <div class="item-title">Sản phẩm nổi bật
                    </div>
                    </a>
                </div>
                <div class="container">
                    <div class="filter-buttons">
                        <button type="button" class="filter-button" onclick="view_obj(1,'<?= $makh ?>')">Giày đế cỏ nhân tạo
                            (TF)</button>
                        <button type="button" class="filter-button" onclick="view_obj(2,'<?= $makh ?>')">Giày đế cỏ tự nhiên
                            (FG)</button>
                        <button type="button" class="filter-button" onclick="view_obj(3,'<?= $makh ?>')">Găng tay thủ môn</button>
                        <button type="button" class="filter-button" onclick="view_obj(4,'<?= $makh ?>')">Phụ kiện bóng đá</button>
                    </div>

                    <style>
                        .loading {
                            width: 100%;
                            text-align: center;

                        }

                        img.gif {
                            width: 50px;
                            display: flex;
                        }
                    </style>

                    <div class="view_obj">
                        <div class="loading">
                            <img src="../assets/images/loading.gif" alt="" class="gif">
                        </div>
                    </div>

                    <script>
                        // Giả sử $makh là biến PHP chứa giá trị cần thiết
                        let makh = <?= json_encode($makh) ?>; // Xuất $makh an toàn vào JavaScript

                        window.addEventListener('load', function() {
                            view_obj(1, makh); // Sử dụng biến JavaScript makh
                        });

                        function view_obj(your_value, makh) {
                            $.post("pages/trang-chu/view_obj.php", {
                                your_value: your_value,
                                makh: makh
                            }, function(data, status) {
                                if (status) {
                                    $(".view_obj").html(data);
                                }
                            });
                        };
                    </script>



                </div>
                <a href="index.php?pages=danh-muc">
                    <span class="block-button block-button--outline-black">Xem tất cả</span>
                </a>
            </div>



            <div class="main-container">
                <div class="main-title-container">
                    <a href="index.php?pages=sp-moi&page=1">
                        <div class="item-title">Bạn có thể mua !? </div>
                    </a>
                </div>
                <div class="product-slider">
                    <div class="product-container-random">
                        <!-- Products -->
                        <?php foreach ($sp__Get_Top_Random as $item) : ?>
                            <?php if (count($sp__Get_Top_Random) > 0) : ?>
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
                                                <?php if (number_format($dg->ShowDonGia__Get_By_Id_Spdg($item->masp)) < number_format($dg->ShowDonGiaMax__Get_By_Id_Spdg($item->masp))) : ?>
                                                    <span class="original-price"><s><?= number_format($dg->ShowDonGiaMax__Get_By_Id_Spdg($item->masp)) ?>₫</s></span>
                                                <?php endif ?>
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
<!-- <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<div id="map" style="height: 400px;"></div> -->

<script>
    function addCartSize(masp) {
        // Kiểm tra xem đã chọn size chưa
        var selectedSize = document.querySelector('input[name="size"]:checked');

        if (!selectedSize) {
            // Nếu chưa chọn size, hiển thị thông báo với SweetAlert2
            Swal.fire({
                icon: 'warning',
                title: 'Vui lòng chọn kích thước',
                text: 'Bạn cần chọn kích thước trước khi thêm vào giỏ hàng.',
            });
            return;
        }
        $.ajax({
            type: "POST",
            url: "./components/action.php",
            data: {
                action: "add",
                masp: masp,
                idsize: idsize
            },
            success: function(response) {
                console.log(response);
                $("#cart-item").text(response);
                Swal.fire({
                    icon: "success",
                    title: "Đã thêm vào giỏ",
                    confirmButtonText: "OK",
                });
            },
        });

    }

    function buyNow(masp) {
        // Kiểm tra xem đã chọn size chưa
        var selectedSize = document.querySelector('input[name="size"]:checked');
        const cartDiv = document.querySelector('.navbar-display-cart');


        if (!selectedSize) {
            // Nếu chưa chọn size, hiển thị thông báo với SweetAlert2
            Swal.fire({
                icon: 'warning',
                title: 'Vui lòng chọn kích thước',
                text: 'Bạn cần chọn kích thước trước khi thêm vào giỏ hàng.',
            });
            return;
        }
        $.ajax({
            type: "POST",
            url: "./components/action.php",
            data: {
                action: "add",
                masp: masp,
                idsize: idsize
            },
            success: function(response) {
                console.log(response);
                $("#cart-item").text(response);
                cartDiv.click();
            },
        });
    }

    function view(masp, maloai, makh) {
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

    function viewBuy(masp, maloai, makh) {
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

    function viewCart(masp, maloai, makh) {
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


    // var map = L.map('map').setView([10.0501742, 105.752894], 13);

    // L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    //     attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    // }).addTo(map);

    // // Add geocoder control
    // L.Control.geocoder({
    //     defaultMarkGeocode: false
    // }).addTo(map);
</script>