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
// $sp__Get_Top_Sale = $sp->SanPham__Get_Top_Sale();
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
                        <div class="sp-item-container__chitiet__left">
                            <div class="tab-group-1">
                                <div class="sp-thich">
                                    <?php if(isset($_SESSION['user'])):?>
                                    <div class="btn btn-sm color-0 background-7" onclick="addCart('<?= $masp ?>')">
                                        <i class="bx bx-cart"></i> Mua ngay
                                    </div>
                                    <?php else:?>
                                        <div class="btn btn-sm btn-secondary" onclick="return checkLogin()">
                                        <i class="bx bx-cart"></i> Mua ngay
                                    </div>
                                    <?php endif?>
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
<?PHP //thêm vào đây ?>                                    </div>
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
    function addCart(masp) {
        $.ajax({
            type: "POST",
            url: "./components/action.php",
            data: {
                action: "add",
                masp: masp
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