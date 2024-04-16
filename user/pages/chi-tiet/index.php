<?php
require_once '../model/SanPhamModel.php';
require_once '../model/AnhSpModel.php';
require_once '../model/CommonModel.php';
require_once '../model/DonGiaModel.php';
require_once '../model/SizeModel.php';

$size = new SizeModel();
$dg = new DonGiaModel();
$sp = new SanPhamModel();
$anhSp = new AnhSpModel();
$cm = new CommonModel();

if (!isset($_GET['masp'])) {
    return;
}
if (!isset($_GET['maloai'])) {
    return;
}
$masp = $_GET['masp'];
$maloai = $_GET['maloai'];

$sp__Get_By_Id = $sp->SanPham__Get_By_Id($masp);
$sp__Get_By_IdLoai = $sp->SanPham__Get_By_IdLoai($maloai);
$size__Get_By_IdLoai = $size->Size__Get_By_Id_Loai($maloai);

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
                            <h5 class="text-danger"><b><?= number_format($dg->ShowDonGia__Get_By_Id_Spdg($masp)) ?>đ</b></h5>
                        </div>
                        <div class="form-check">
                            <br>
                            <div class="row">
                                <h5 class="text-normal">Chọn kích thước: </h5>
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
                        <br>
                        <div class="sp-item-container__chitiet__left">
                            <div class="tab-group-1">
                                <div class="sp-thich">
                                    <?php if (isset($_SESSION['user'])) : ?>
                                        <div class="btn btn-sm color-0 background-7" onclick="addCartSize('<?= $masp ?>')">
                                            <i class="bx bx-cart"></i> Mua ngay
                                        </div>
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
                            <a href="index.php?pages=sp-chi-tiet&masp=<?= $item->masp ?>&maloai=<?= $item->maloai ?>">
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
                            <a href="index.php?pages=chi-tiet&masp=<?= $item->masp ?>&maloai=<?= $item->maloai ?>">
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
                        <a href="index.php?pages=chi-tiet&masp=<?= $item->masp ?>&maloai=<?= $item->maloai ?>">
                            <div class="manga-container">
                                <div class="manga-thumbnail">
                                    <img src="../assets/<?= $anhSp__Get_By_Id_Sp_First->hinhanh ?>">
                                    <span class="manga-note background-8"><?= number_format($dg->ShowDonGia__Get_By_Id_Spdg($item->masp)) ?>₫</i></span>
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
    let idsize = null;

    function selectSize(size) {
        // Loại bỏ lớp "selected" từ tất cả các kích thước trước đó
        $('.size-option').removeClass('selected');
        // Thêm lớp "selected" cho kích thước được chọn
        $(`#size-label-${size}`).addClass('selected');
        idsize = size;
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

    function addCart(masp) {

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

    window.addEventListener('load', function() {
        // luot xem
        viewSanpham('<?= $masp ?>');

        // Lấy masp khi trang được tải
        masp = <?= $masp ?>;
        typetrack = 1;
        // Bắt đầu tính thời gian khi trang được tải
        startTimerCt();
    });

    window.addEventListener('beforeunload', function() {
        // Dừng tính thời gian trước khi người dùng rời khỏi trang
        endTimerCt();
    });

    function startTimerCt() {
        // Khởi động đồng hồ
        timer = setInterval(() => updateTimeCt(), 1000);
    }

    function endTimerCt() {
        clearInterval(timer);
        if (timeCounter > 3) {
            saveTimeCt(); // Không cần truyền masp ở đây vì nó là biến toàn cục
        }
        timeCounter = 0;
    }

    function updateTimeCt() {
        timeCounter++;
    }

    function saveTimeCt() {
        // Gửi dữ liệu thông qua AJAX
        $.ajax({
            type: "POST",
            url: "components/action.php",
            data: {
                action: "timetracking",
                masp: masp,
                timeCounter: timeCounter,
                typetrack: typetrack,
            },
            success: function(response) {
                console.log("Data sent successfully!");
            },
            error: function(xhr, status, error) {
                console.error("Failed to send data: " + error);
            }
        });
    }

    // code here
</script>