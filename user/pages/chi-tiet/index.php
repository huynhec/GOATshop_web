<?php
require_once '../model/SanPhamModel.php';
require_once '../model/AnhSpModel.php';
require_once '../model/CommonModel.php';
$sp = new SanPhamModel();
$anhSp = new AnhSpModel();
$cm = new CommonModel();

if (!isset($_GET['masp'])) {
    return;
}
$masp = $_GET['masp'];

$sp__Get_By_Id = $sp->SanPham__Get_By_Id($masp);
$sp__Get_Top_Sale = $sp->SanPham__Get_Top_Sale();
$sp__Get_Top_Same = $sp->SanPham__Get_Top_Same($sp__Get_By_Id->math,  $masp);
$anhSp__Get_By_Id_Sp_Not_First = $anhSp->AnhSp__Get_By_Id_Sp_Not_First($sp__Get_By_Id->masp);
?>
<main class="main">
    <div class="main-container">
        <div class="main-container__chitiet__left">
            <div class="main-title-container">
                <a href="">
                </a>
            </div>
            <div class="manga-container__chitiet__left">
                <div class="slide-container">
                    <div id="slide">
                        <?php foreach ($anhSp__Get_By_Id_Sp_Not_First as $item) : ?>
                            <img src="../assets/<?= $item->hinhanh ?>" class="item" alt="">
                        <?php endforeach ?>
                    </div>
                    <br>
                    <div class="thumbnail-container">
                        <?php foreach ($anhSp__Get_By_Id_Sp_Not_First as $key => $item) : ?>
                            <img src="../assets/<?= $item->hinhanh ?>" class="thumbnail" data-index="<?= $key ?>" alt="" onclick="showSlide(<?= $key ?>)">
                        <?php endforeach ?>
                    </div>
                </div>
                <hr>
                <div class="manga-sp-container__chitiet__left">
                    <div class="manga-title color-2"><?= $sp__Get_By_Id->tensp ?></div>
                    <div class="sp-container__top">
                        <div class="tab-group-1">
                            <h5 class="text-danger"><b><?= number_format($sp__Get_By_Id->dongia) ?>đ</b></h5>
                        </div>
                        <?php if ($sp__Get_By_Id->maloai == '1') : ?>
                            <h5 class="text-normal">Chọn kích thước:</h5>
                            <div>
                                <!-- code chọn size (39 đến 44) -->
                                <div>
                                    <label for="size39" class="size-option btn-outline-primary" onclick="selectSize('39')">
                                        <input type="radio" id="size39" name="size" value="39">
                                        39
                                    </label>

                                    <label for="size40" class="size-option" onclick="selectSize('40')">
                                        <input type="radio" id="size40" name="size" value="40">
                                        40
                                    </label>

                                    <label for="size41" class="size-option" onclick="selectSize('41')">
                                        <input type="radio" id="size41" name="size" value="41">
                                        41
                                    </label>

                                    <label for="size42" class="size-option" onclick="selectSize('42')">
                                        <input type="radio" id="size42" name="size" value="42">
                                        42
                                    </label>

                                    <label for="size43" class="size-option" onclick="selectSize('43')">
                                        <input type="radio" id="size43" name="size" value="43">
                                        43
                                    </label>

                                    <label for="size44" class="size-option" onclick="selectSize('44')">
                                        <input type="radio" id="size44" name="size" value="44">
                                        44
                                    </label>
                                </div>
                            </div>
                        <?php elseif ($sp__Get_By_Id->maloai == '3') : ?>
                            <h5 class="text-normal">Chọn kích thước:</h5>
                            <div>
                                <!-- code chọn size (S M L X XX XXX) -->
                                <div>
                                    <label for="sizeS" class="size-option" onclick="selectSize('S')">
                                        <input type="radio" id="sizeS" name="size" value="S">
                                        S
                                    </label>

                                    <label for="sizeM" class="size-option" onclick="selectSize('M')">
                                        <input type="radio" id="sizeM" name="size" value="M">
                                        M
                                    </label>

                                    <label for="sizeL" class="size-option" onclick="selectSize('L')">
                                        <input type="radio" id="sizeL" name="size" value="L">
                                        L
                                    </label>

                                    <label for="sizeXL" class="size-option" onclick="selectSize('XL')">
                                        <input type="radio" id="size" name="size" value="XX">
                                        XL
                                    </label>

                                </div>
                            </div>
                        <?php elseif ($sp__Get_By_Id->maloai == '6') : ?>
                            <h5 class="text-normal">Chọn kích thước:</h5>
                            <div>
                                <div>
                                    <label for="size6" class="size-option" onclick="selectSize('6')">
                                        <input type="radio" id="size6" name="size" value="6">
                                        6
                                    </label>

                                    <label for="size7" class="size-option" onclick="selectSize('7')">
                                        <input type="radio" id="size7" name="size" value="7">
                                        7
                                    </label>

                                    <label for="size8" class="size-option" onclick="selectSize('8')">
                                        <input type="radio" id="size8" name="size" value="8">
                                        8
                                    </label>

                                    <label for="size9" class="size-option" onclick="selectSize('9')">
                                        <input type="radio" id="size9" name="size" value="9">
                                        9
                                    </label>

                                    <label for="size10" class="size-option" onclick="selectSize('10')">
                                        <input type="radio" id="size10" name="size" value="10">
                                        10
                                    </label>

                                </div>
                            </div>
                        <?php endif ?>

                        <div class="sp-item-container__chitiet__left">
                            <div class="tab-group-1">
                                <div class="sp-thich">
                                    <?php if (isset($_SESSION['user'])) : ?>
                                        <?php if ($sp__Get_By_Id->maloai == '1' || $sp__Get_By_Id->maloai == '3' || $sp__Get_By_Id->maloai == '6') : ?>
                                            <div class="btn btn-sm color-0 background-7" onclick="addCartSize('<?= $masp ?>')">
                                                <i class="bx bx-cart"></i> Mua ngay
                                            </div>
                                        <?php else : ?>
                                            <div class="btn btn-sm color-0 background-7" onclick="addCart('<?= $masp ?>')">
                                                <i class="bx bx-cart"></i> Mua ngay
                                            </div>
                                        <?php endif; ?>


                                    <?php else : ?>
                                        <div class="btn btn-sm btn-secondary" onclick="return checkLogin()">
                                            <i class="bx bx-cart"></i> Mua ngay
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="manga-container__chitiet__bottom">
                <div class="manga-sp-container__chitiet__bottom">
                    <div class="manga-title color-7">Mô tả</div>
                    <div class="chapter-container__chitiet__bottom__noi_dung">
                        <?php if ($sp__Get_By_Id->mota != "") : ?>
                            <?= $sp__Get_By_Id->mota ?>
                        <?php else : ?>
                            <a href="index.php?pages=sp-chi-tiet&masp=<?= $item->masp ?>">
                                <span class="chapter-name"></span>Đang cập nhật...</span>
                            </a>
                        <?php endif ?>
                    </div>
                </div>
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
        </div>
    </div>
    <div class="main-container">
        <div class="main-title-container">
            <a href="index.php?pages=sp-ngau-nhien">
                <div class="item-title color-8"><i class='bx bx-book-reader'></i>SẢN PHẨM CÙNG THƯƠNG HIỆU</div>
            </a>
        </div>
        <div class="main-item-container">
            <?php foreach ($sp__Get_Top_Same as $item) : ?>
                <?php if (count($sp__Get_Top_Same) > 0) : ?>
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
<script>
    let masize = null;

    function selectSize(size) {
        // Loại bỏ lớp "selected" từ tất cả các kích thước trước đó
        $('.size-option').removeClass('selected');
        // Thêm lớp "selected" cho kích thước được chọn
        $(`[for="size${size}"]`).addClass('selected');
        // Set giá trị cho biến masize dựa trên giá trị của size
        switch (size) {
            case '39':
                masize = '1';
                break;
            case '40':
                masize = '2';
                break;
            case '41':
                masize = '3';
                break;
            case '42':
                masize = '4';
                break;
            case '43':
                masize = '5';
                break;
            case '44':
                masize = '6';
                break;
            case 'S':
                masize = '7';
                break;
            case 'M':
                masize = '8';
                break;
            case 'L':
                masize = '9';
                break;
            case 'XL':
                masize = '11';
                break;
            case '6':
                masize = '12';
                break;
            case '7':
                masize = '13';
                break;
            case '8':
                masize = '14';
                break;
            case '9':
                masize = '15';
                break;
            case '10':
                masize = '16';
                break;

        }
        return masize;
    }

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
                masize: masize
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

    function addCart(masp) {

        $.ajax({
            type: "POST",
            url: "./components/action.php",
            data: {
                action: "add",
                masp: masp,
                masize: 0
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

    // Định nghĩa hàm showSlide trước khi sử dụng
    function showSlide(index) {
        let slides = document.querySelectorAll('.item');
        slides.forEach(function(slide) {
            slide.style.display = 'none';
        });
        slides[index].style.display = 'block';
    }
    window.addEventListener('load', function(event) {

        let slideInterval;

        function showSlides() {
            let lists = document.querySelectorAll('.item');
            document.getElementById('slide').appendChild(lists[0]);
        }

        function startSlideShow() {
            slideInterval = setInterval(showSlides, 2000); // Change image every 2 seconds
        }

        function stopSlideShow() {
            clearInterval(slideInterval);
        }

        startSlideShow(); // Start slideshow initially

        // Stop slideshow on hover
        let slideContainer = document.querySelector('.slide-container');
        slideContainer.addEventListener('mouseenter', stopSlideShow);
        slideContainer.addEventListener('mouseleave', startSlideShow);
    });
</script>