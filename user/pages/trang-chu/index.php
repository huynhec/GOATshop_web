<?php
require_once '../model/SanPhamModel.php';
require_once '../model/AnhSpModel.php';
require_once '../model/CommonModel.php';
require_once '../model/DonGiaModel.php';
require_once '../model/GoiYModel.php';

$dg = new DonGiaModel();
$sp = new SanPhamModel();
$anhSp = new AnhSpModel();
$cm = new CommonModel();
$gy = new GoiYModel();

$makh = isset($_SESSION['user']->makh) ? $_SESSION['user']->makh : 0;

$sp__Get_Top_Updated_5 = $sp->SanPham__Get_Top_Updated(6);
$sp__Get_Top_Updated_24 = $sp->SanPham__Get_Top_Updated(24);
$sp__Get_Top_Sale = $sp->SanPham__Get_Top_Sale();
$sp__Get_Top_Random = $sp->SanPham__Get_Top_Random(6);
$goi_Y_User_Based = $gy->Goi_Y_User_Based($makh);

$top = 0;
?>

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
        <?php if (isset($_SESSION['user'])) : ?>
            <div class="main-title-container">
                <a href="index.php?pages=sp-moi&page=1">
                    <div class="item-title color-2" style="font-weight: bold; font-size: 24px;">Dành riêng cho bạn!
                    </div>
                </a>
            </div>
            <div class="main-item-container">
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
                                        <!-- <div class="product-tags">
                                        <div class="tag-saleoff text-center">-23%</div>
                                    </div> -->
                                        <div class="product-actions text-center clearfix">
                                            <div>
                                                <button type="button" class="btnQuickView quick-view medium--hide small--hide" data-handle="/products/nike-mercurial-vapor-13-academy-tf-2" onclick="return view('<?= $item->masp ?>','<?= $item->maloai ?>','<?= $_SESSION['user']->makh ?? 0; ?>')">
                                                    <span><i class="fa fa-search-plus" aria-hidden="true"></i></span>
                                                </button>
                                                <button type="button" class="btnBuyNow buy-now medium--hide small--hide" data-id="1085955545" onclick="buyNow('<?= $item->masp ?>')"><span>Mua ngay</span></button>
                                                <button type="button" class="btnAddToCart add-to-cart medium--hide small--hide" data-id="1085955545" onclick="addCartSize('<?= $item->masp ?>')">
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
            <?php endif;?>
            <div class="main-title-container">
                <a href="index.php?pages=sp-moi&page=1">
                    <div class="item-title color-2" style="font-weight: bold; font-size: 24px;">Sản phẩm khuyến mãi
                    </div>
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
                                                <button type="button" class="btnQuickView quick-view medium--hide small--hide" data-handle="/products/nike-mercurial-vapor-13-academy-tf-2" onclick="return view('<?= $item->masp ?>','<?= $item->maloai ?>','<?= $_SESSION['user']->makh ?? 0; ?>')">
                                                    <span><i class="fa fa-search-plus" aria-hidden="true"></i></span>
                                                </button>
                                                <button type="button" class="btnBuyNow buy-now medium--hide small--hide" data-id="1085955545" onclick="buyNow('<?= $item->masp ?>')"><span>Mua ngay</span></button>
                                                <button type="button" class="btnAddToCart add-to-cart medium--hide small--hide" data-id="1085955545" onclick="addCartSize('<?= $item->masp ?>')">
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
                        <div class="item-title color-2" style="font-weight: bold; font-size: 24px;">Sản phẩm nổi bật
                        </div>
                    </a>
                </div>
                <div class="container">
                    <div class="filter-buttons">
                        <button type="button" class="filter-button" onclick=view_obj(1)>Giày đế cỏ nhân tạo
                            (TF)</button>
                        <button type="button" class="filter-button" onclick=view_obj(2)>Giày đế cỏ tự nhiên
                            (FG)</button>
                        <button type="button" class="filter-button" onclick=view_obj(3)>Găng tay thủ môn</button>
                        <button type="button" class="filter-button" onclick=view_obj(4)>Phụ kiện bóng đá</button>
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
                        window.addEventListener('load', function() {
                            view_obj(1);
                        })

                        function view_obj(your_value) {
                            $.post("pages/trang-chu/view_obj.php", {
                                your_value: your_value,
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
                        <div class="item-title color-2" style="font-weight: bold; font-size: 24px;">Bạn có thể mua !? </div>
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
        fetch(
                `https://maps.googleapis.com/maps/api/geocode/json?latlng=${latitude},${longitude}&key=AIzaSyBWzRuWS-rxMCENShE23x4Gh1f7R3vAL1Y`
            )
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