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
$sp__Get_Top9_Attribute_1 = $sp->SanPham__Get_Top_Attribute_1(9);
$sp__Get_Top9_Attribute_2 = $sp->SanPham__Get_Top_Attribute_2(9);
$sp__Get_Top9_Attribute_3 = $sp->SanPham__Get_Top_Attribute_3(9);
$sp__Get_Top9_Attribute_4 = $sp->SanPham__Get_Top_Attribute_4(9);
$sp__Get_Top_Updated_24 = $sp->SanPham__Get_Top_Updated(24);
$sp__Get_Top_Sale = $sp->SanPham__Get_Top_Sale();
$sp__Get_Top_Random = $sp->SanPham__Get_Top_Random(6);

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

                        <button id="button1" value="1">Giày đế cỏ nhân tạo (TF)</button>
                        <button id="button2" value="2">Giày đế cỏ tự nhiên (FG)</button>
                        <button id="button3" value="3">Găng tay thủ môn</button>
                        <button id="button4" value="4">Phụ kiện bóng đá</button>
                    </div>
                    <div class="product-grid" id="product-grid">
                        <?php
                        // Khởi tạo biến $your_value và gán giá trị mặc định
                        $your_value = isset($_GET['your_value']) ? $_GET['your_value'] : '1';

                        // Kiểm tra giá trị của biến $your_value
                        if ($your_value == 1) :
                            echo $your_value; ?>
                            <?php foreach ($sp__Get_Top9_Attribute_1 as $item) : ?>
                                <!-- Thêm mã HTML tương ứng với giá trị của biến $item -->
                                <?php if (count($sp__Get_Top9_Attribute_1) > 0) : ?>
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
                            <?php endforeach; ?>
                        <?php elseif ($your_value == 2) :
                            echo $your_value;  ?>

                            <?php foreach ($sp__Get_Top9_Attribute_2 as $item) : ?>
                                <!-- Thêm mã HTML tương ứng với giá trị của biến $item -->
                                <?php if (count($sp__Get_Top9_Attribute_2) > 0) : ?>
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
                            <?php endforeach; ?>
                        <?php elseif ($your_value == 3) : ?>
                            <?php foreach ($sp__Get_Top9_Attribute_3 as $item) : ?>
                                <!-- Thêm mã HTML tương ứng với giá trị của biến $item -->
                                <?php if (count($sp__Get_Top9_Attribute_3) > 0) : ?>
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
                            <?php endforeach; ?>
                        <?php elseif ($your_value == 4) : ?>
                            <?php foreach ($sp__Get_Top9_Attribute_4 as $item) : ?>
                                <!-- Thêm mã HTML tương ứng với giá trị của biến $item -->
                                <?php if (count($sp__Get_Top9_Attribute_4) > 0) : ?>
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
                            <?php endforeach; ?>
                        <?php endif; ?>




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
    // // Lấy danh sách các nút
    // var buttons = document.querySelectorAll('button');

    // // Lặp qua từng nút và thêm sự kiện click
    // buttons.forEach(function(button) {
    //     button.addEventListener('click', function() {
    //         // Lấy giá trị từ thuộc tính value của nút
    //         var value = this.value;
    //         console.log("Giá trị củah nút:", value);

    //         // Gửi yêu cầu AJAX sử dụng jQuery
    //         $.ajax({
    //             url: './pages/trang-chu/index.php',
    //             type: "GET",
    //             data: {
    //                 your_value: value
    //             },
    //             success: function(response) {
    //                 // Xử lý phản hồi ở đây
    //             },
    //             error: function(xhr, status, error) {
    //                 console.error(xhr.responseText);
    //             }
    //         });
    //     });
    // });
    // Tạo một đối tượng XMLHttpRequest
    // Lấy danh sách các nút
    var buttons = document.querySelectorAll('button');
    var buttonValues = []; // Khai báo một mảng để lưu giá trị của các nút

    // Lặp qua từng nút và thêm sự kiện click
    buttons.forEach(function(button) {
        button.addEventListener('click', function() {
            // Lấy giá trị từ thuộc tính value của nút
            var value = this.value;
            console.log("Giá trị của nút:", value);
            // Thêm giá trị vào mảng buttonValues
            buttonValues.push(value);
            // Gọi hàm hoặc thực hiện các hành động khác với giá trị nếu cần
            doSomethingWithValue(value);
        });
    });

    function doSomethingWithValue(value) {
        var xhttp = new XMLHttpRequest();

        // Xác định phương thức và URL của request
        var url = "http://localhost/GOATshop/user/index.php";
        var params = "pages=trang-chu&your_value=";
        url = url + "?" + params + value; // Thêm dấu & vào trước giá trị của nút

        // Mở một kết nối GET với URL
        xhttp.open("GET", url, true);

        // Định nghĩa hàm callback để xử lý kết quả
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Chuyển đến trang mới với các tham số đã chỉ định
                window.location.href = url;
            }
        };

        // Gửi request
        xhttp.send();
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