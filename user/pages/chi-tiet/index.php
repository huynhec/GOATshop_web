<?php
require_once '../model/SanPhamModel.php';
require_once '../model/AnhSpModel.php';
require_once '../model/CommonModel.php';
require_once '../model/DonGiaModel.php';
require_once '../model/SizeModel.php';
require_once '../model/ThuongHieuModel.php';

$th = new ThuongHieuModel();
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
$anhSp__Get_By_Id_Sp_Thumbnail = $anhSp->AnhSp__Get_By_Id_Sp_Thumbnail($masp);
?>
<!-- <main class="main">
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
</script> -->

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giày bóng đá trẻ em Nike Air Zoom Mercurial</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <section id="breadcrumb-wrapper" class="breadcrumb-w-img">
        <picture>
            <img src="../assets/images/Black logo - no background copy.png">

        </picture>
        <div class="breadcrumb-overlay"></div>

    </section>
    <div class="product-container">
        <div class="product-images">
            <div class="thumbnail-images">
                <?php foreach ($anhSp__Get_By_Id_Sp_Not_First as $key => $item) : ?>
                    <img src="../assets/<?= $item->hinhanh ?>" alt="" onclick="changeImage('../assets/<?= $item->hinhanh ?>')">
                <?php endforeach ?>

            </div>
            <div class="main-image">

                <img id="currentImage" src="../assets/<?= $anhSp__Get_By_Id_Sp_Thumbnail->hinhanh ?>" alt="Nike Air Zoom Mercurial" style=" height: 690px; width: 690px;">
            </div>
        </div>
        <div class="product-details">
            <h1><?= $sp__Get_By_Id->tensp ?></h1>
            <p class="brand">Thương hiệu: <?= ($th->ThuongHieu__Get_By_Id($sp__Get_By_Id->math))->tenth ?> | </p>
            <!-- <p class="brand"> Loại: Giày sân cỏ tự nhiên - Firm Ground</p> -->
            <p class="price"><?= number_format($dg->ShowDonGia__Get_By_Id_Spdg($masp)) ?>đ</p>
            <!-- <p class="installment">Trả sau 2,475,000đ x2 kỳ với Fundiin</p>
            <p class="discount">Giảm đến 100K khi thanh toán qua Fundiin. <a href="#">xem thêm</a></p> -->
            <ul class="features">
                <li>Ưu đãi cho khách hàng thành viên</li>
                <li>Freeship toàn quốc</li>
                <li>Được đổi trả lên đến 7 ngày</li>
                <li>Bảo hành miễn phí lên đến 1 năm</li>
                <li>Hỗ trợ đổi trả hàng thuận tiện</li>
                <li>Cam kết 100% chính hãng</li>
            </ul>
            <div class="size-selection">
                <div class="row">
                    <h5 class="text-normal">Kích thước: </h5>
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

                <!-- <label for="size">Kích thước | <a href="#">Hướng dẫn chọn size</a></label>
                <select id="size" name="size">
                    <option value="36.5">36.5</option>
                </select> -->
            </div>
            <!-- <div class="quantity-selection">
                <label for="quantity">Số lượng</label>
                <button onclick="decreaseQuantity()">-</button>
                <input type="number" id="quantity" name="quantity" value="1" min="1">
                <button onclick="increaseQuantity()">+</button>
            </div> -->
            <div class="product-size-hotline">
                <div class="product-hotline">
                    <i class="fa fa-mobile" aria-hidden="true"></i> Hotline &amp; Zalo hỗ trợ: 098 5259052 <a href="tel:"></a>
                </div>
            </div>

            <?php if (isset($_SESSION['user'])) : ?>
                <div class="actions">
                    <button class="buy-now" onclick="buyNow('<?= $masp ?>')">Mua ngay</button>
                    <button class="add-to-cart" onclick="addCartSize('<?= $masp ?>')">Thêm vào giỏ</button>
                </div>
            <?php else : ?>
                <div class="actions">
                    <button class="buy-now" onclick="return checkLogin()">Mua ngay</button>
                    <button class="add-to-cart" onclick="return checkLogin()">Thêm vào giỏ</button>
                </div>
            <?php endif ?>

        </div>
    </div>


    <div class="grid">
        <div class="grid__item large--nine-twelfths medium--one-whole small--one-whole">
            <div class="product-description-wrapper">
                <div class="tab clearfix">
                    <button class="pro-tablinks active" onclick="openProTabs(event, 'protab1')" id="defaultOpenProTabs">Mô tả</button>
                    <button class="pro-tablinks" onclick="openProTabs(event, 'protab2')">Hướng dẫn sử dụng và bảo quản giày </button>
                    <button class="pro-tablinks" onclick="openProTabs(event, 'protab3')">Chính sách bảo hành và đổi trả</button>
                </div>
                <div id="protab1" class="pro-tabcontent" style="display: block;">
                    <?php if ($sp__Get_By_Id->mota != "") : ?>
                        <?= $sp__Get_By_Id->mota ?>
                    <?php else : ?>
                        <a href="index.php?pages=sp-chi-tiet&masp=<?= $item->masp ?>&maloai=<?= $item->maloai ?>">
                            <span class="chapter-name"></span>Đang cập nhật...</span>
                        </a>
                    <?php endif ?>
                </div>
                <div id="protab2" class="pro-tabcontent" style="display: none;">
                    <p><span style="font-size:18px"><strong>HƯỚNG DẪN SỬ DỤNG GIÀY BÓNG ĐÁ MỚI</strong></span></p>
                    <ul>
                        <li><span style="font-size:18px">Bạn nên nới lỏng hết dây buộc giày khi mang lần đầu.</span></li>
                        <li><span style="font-size:18px">Không nên mang vớ quá dày khi lần đầu mang giày mới vì sẽ làm tăng size chân của bạn.</span></li>
                        <li><span style="font-size:18px">Nên mang vớ hoặc sử dụng miếng đón gót giày sẽ dễ dàng hơn.</span></li>
                        <li><span style="font-size:18px">Khoảng cách từ mũi giày đến mũi bàn chân từ 0.5 - 1cm là hoàn hảo nhất để đá bóng.</span></li>
                        <li><span style="font-size:18px">Giày lúc đầu mang sẽ hơi ôm chân, nhưng sẽ giãn sau 4-5 trận.</span></li>
                    </ul>
                    <p><span style="font-size:18px"><strong>HƯỚNG DẪN BẢO QUẢN GIÀY BÓNG ĐÁ</strong></span></p>
                    <ul>
                        <li><span style="font-size:18px">Khi không sử dụng, giày cần được bảo quản nơi khô thoáng, tránh ẩm ướt và ánh nắng trực tiếp. Nên bỏ giày vào hộp cẩn thận khi không sử dụng giày trong thời gian dài.</span></li>
                        <li><span style="font-size:18px">Nên định kỳ vệ sinh giày từ 5-7 ngày/lần bằng khăn sạch được thấm xà phòng hoặc dùng các dung dịch chuyên vệ sinh giày như Crep Protect để đôi giày của bạn luôn trong trạng thái tốt nhất.</span></li>
                        <li><span style="font-size:18px">Không chà mạnh tay và không dùng các chất tẩy rửa mạnh khi vệ sinh giày.</span></li>
                        <li><span style="font-size:18px">Hạn chế để nước thấm vào trong giày.</span></li>
                        <li><span style="font-size:18px">Sau khi sử dụng giày, nên để giày ở nơi khô thoáng, không để vớ bên trong giày. Nên để giấy báo, các hạt hút ẩm vào bên trong giày để hạn chế mùi hôi hoặc dùng các công cụ chuyên dụng như viên tẩy mùi hôi của Crep Protect để giày của bạn luôn sẵn sàng cho trận đấu. Ngoài ra chúng tôi cũng có cung cấp dịch vụ vệ sinh giày bóng đá và sản phẩm Crep Protect, bạn có thể tham khảo tại website: GOATshop.com.</span></li>
                    </ul>
                </div>
                <div id="protab3" class="pro-tabcontent" style="display: none;">
                    <h1><span style="font-size:18px"><strong>HƯỚNG DẪN BẢO HÀNH</strong></span></h1>
                    <p><span style="font-size:18px">Thời gian hỗ trợ bảo hành giày: 12 tháng kể từ ngày mua hàng.<br>
                            # Điều kiện áp dụng:</span></p>
                    <ul>
                        <li><span style="font-size:18px">Bảo hành các trường hợp cho lỗi của nhà sản xuất như: hở keo, đứt chỉ, tróc đế…</span></li>
                        <li><span style="font-size:18px">Khi bảo hành khách hàng phải cung cấp hóa đơn của sản phẩm.</span></li>
                        <li><span style="font-size:18px">Thời gian xử lý bảo hành: 1-2 tuần.</span></li>
                    </ul>
                    <p><br><span style="font-size:18px"># Lưu ý:<br>Không bảo hành đối với các trường hợp sau:</span></p>
                    <ul>
                        <li><span style="font-size:18px">Bể đinh hoặc rách da do bị vật sắc nhọn đâm thủng</span></li>
                        <li><span style="font-size:18px">Không hỗ trợ đối với những sản phẩm có thông báo: không áp dụng đổi trả - bảo hành.</span></li>
                        <li><span style="font-size:18px">Không nhận bảo hành các sản phẩm thuộc dòng Sale.</span></li>
                    </ul>
                    <p><span style="font-size:18px">Trường hợp hết thời gian bảo hành, giày dép hư hỏng do hao mòn tự nhiên hoặc bị tác động mạnh từ bên ngoài, GOATshop vẫn tiếp nhận bảo hành tuy nhiên chi phí sửa chữa và vận chuyển khách hàng thanh toán.</span></p>
                    <p>&nbsp;</p>
                    <p><span style="font-size:18px"><strong>HƯỚNG DẪN ĐỔI TRẢ</strong></span></p>
                    <p><span style="font-size:18px"># Điều kiện áp dụng</span></p>
                    <p><br><span style="font-size:18px">Hỗ trợ đổi hàng trong vòng 7 ngày với điều kiện:</span></p>
                    <ul>
                        <li><span style="font-size:18px">Giày chưa sử dụng, chưa chạy thử, đá thử (mới 100%)</span></li>
                        <li><span style="font-size:18px">Giày hoàn toàn sạch sẽ, không dơ bẩn, trầy xước</span></li>
                        <li><span style="font-size:18px">Còn nguyên hộp, nguyên tem</span></li>
                        <li><span style="font-size:18px">Có hóa đơn mua hàng</span></li>
                    </ul>
                    <p><span style="font-size:18px">Chúng tôi chỉ hỗ trợ đổi 1 lần duy nhất cho mỗi đơn hàng.</span></p>
                    <p><span style="font-size:18px">Không hỗ trợ đổi hàng với các sản phẩm thuộc danh mục đặt trước (Pre-Order).</span></p>
                    <p><span style="font-size:18px">Quý khách có thể liên hệ Hotline: 0339 400 730 hoặc Email: huynhbarca@gmail.com nếu muốn đổi trả sau 7 ngày kể từ ngày nhận hàng.</span></p>
                    <p><span style="font-size:18px"># Lưu ý:</span></p>
                    <ul>
                        <li><span style="font-size:18px">Giày đổi phải có giá trị tương đương. Trường hợp sản phẩm mới có giá trị cao hơn, khách hàng vui lòng bù thêm khoản chênh lệch. Trường hợp sản phẩm đổi mới có giá trị thấp hơn, GOATshop sẽ hoàn trả khoản chênh lệch (tối đa 500,000 VNĐ)</span></li>
                        <li><span style="font-size:18px">Phí vận chuyển trả hàng khách hàng thanh toán (trừ trường hợp GOATshop giao nhầm size hoặc mẫu so với đơn đặt hàng)</span></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="grid__item large--three-twelfths medium--one-whole small--one-whole">
            <div class="product-related-wrapper">
                <p class="section-title">SẢN PHẨM LIÊN QUAN</p>
                <div class="product-recommendations">

                    <?php foreach ($sp__Get_Top_Same as $item) : ?>
                        <?php if (count($sp__Get_Top_Same) > 0) : ?>
                            <?php $anhSp__Get_By_Id_Sp_First = $anhSp->AnhSp__Get_By_Id_Sp_First($item->masp); ?>
                            <?php if (isset($anhSp__Get_By_Id_Sp_First->masp)) : ?>
                                <a href="index.php?pages=chi-tiet&masp=<?= $item->masp ?>&maloai=<?= $item->maloai ?>">
                                    <div class="recommendation">
                                        <img src="../assets/<?= $anhSp__Get_By_Id_Sp_First->hinhanh ?>" alt="">
                                        <p>
                                            <strong><?= $item->tensp ?></strong>
                                            <span><?= number_format($dg->ShowDonGia__Get_By_Id_Spdg($item->masp)) ?>₫</span>
                                        </p>
                                    </div>
                                </a>
                            <?php endif ?>
                        <?php endif ?>
                    <?php endforeach ?>

                </div>
            </div>
        </div>
    </div>


</body>

</html>

<style>
    .pro-tabcontent a,
    .pro-tabcontent p, 
    .pro-tabcontent span {
        filter: contrast(0.5);
    }
    .buy-now,
    .add-to-cart {
        font-weight: bold;
    }

    .grid {
        display: flex;
        /* flex-wrap: wrap; */
        list-style: none;
        max-width: 1200px;
        margin: 0 186px;
        padding-top: 20px;
    }


    .grid__item {
        padding: 0;
    }

    .large--nine-twelfths {
        flex: 0 0 75%;
    }

    .large--three-twelfths {
        flex: 0 0 25%;
    }

    .tab {
        overflow: hidden;
        border-bottom: 1px solid #ccc;
        margin-bottom: 20px;
        background: rgb(0, 0, 0, 0.5);
    }

    .tab button {
        background-color: #3F3F3F;
        color: #fff;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 14px 16px;
        transition: 0.3s;
        font-size: 17px;
        font-weight: bold;

    }

    .tab button:hover {
        background-color: #000000;
        color: #fff;
    }

    .tab button.active {
        background-color: #000000;
        color: #fff;
    }

    .pro-tabcontent {
        display: none;
        padding: 6px 12px;
        border-top: none;
        background-color: #fff;
        /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); */
        /* border-radius: 4px; */
    }

    .product-description-wrapper h1,
    .product-description-wrapper p,
    .product-description-wrapper ul {
        margin: 10px 0;
    }

    .section-title {
        display: block;
        background: #000000;
        color: #fff;
        text-align: center;
        outline: none;
        cursor: pointer;
        padding: 15px;
        margin: 0px;
        font-weight: bold;
    }

    .product-related-wrapper {
        background-color: #fff;
        padding-left: 20px;
        /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); */
        /* border-radius: 4px; */
        margin: 0;
    }

    .product-recommendations {
        padding: 15px;
        background-color: white;
    }

    .product-recommendations a {
        display: flex;
        flex-direction: row;
        align-items: center;
        padding: 10px 0;
        text-decoration: none;
        border-bottom: 1px solid #ddd;
    }

    .product-recommendations img {
        width: 100px;
        height: auto;
        margin-right: 15px;
    }

    .product-recommendations p {
        margin: 0;
        color: black;
    }

    .product-recommendations p strong {
        display: block;
        margin-bottom: 5px;
        font-size: 14px;
    }

    .product-recommendations p span {
        color: #D30000;
        font-size: 14px;
        font-weight: bold;
    }

    .recommendation {
        display: flex;
        margin-bottom: 15px;
        text-align: center;
    }

    .recommendation img {
        max-width: 100%;
        height: 100px;
        border-radius: 4px;
    }

    .recommendation p {
        margin: 5px 0 0;
        text-align: left;
        /* Ensure text is left-aligned */

    }

    .recommendation p strong {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        -webkit-line-clamp: 4;
        /* Number of lines you want to display */
        white-space: normal;
        max-width: 100%;
    }
</style>
<script>
    function changeImage(image) {
        document.getElementById('currentImage').src = image;
    }

    function decreaseQuantity() {
        var quantity = document.getElementById('quantity');
        if (quantity.value > 1) {
            quantity.value = parseInt(quantity.value) - 1;
        }
    }

    function increaseQuantity() {
        var quantity = document.getElementById('quantity');
        quantity.value = parseInt(quantity.value) + 1;
    }

    document.addEventListener('DOMContentLoaded', (event) => {
        document.getElementById("defaultOpenProTabs").click();
    });

    function openProTabs(evt, tabName) {
        let i, tabcontent, tablinks;

        tabcontent = document.getElementsByClassName("pro-tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        tablinks = document.getElementsByClassName("pro-tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }

        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }

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
</script>