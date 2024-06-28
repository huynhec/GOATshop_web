<?php
require_once '../model/CommonModel.php';
require_once '../model/SanPhamModel.php';
require_once '../model/AnhSpModel.php';
require_once '../model/DonGiaModel.php';

$dg = new DonGiaModel();
$cm = new CommonModel();
$anhSp = new AnhSpModel();
$sp = new SanPhamModel();

// Lấy số trang từ tham số truyền vào hoặc mặc định là 1
$page_number = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Lấy danh sách truyện cho trang hiện tại
$sanPham__Get_Ten_Sp_Paged = $sp->SanPham__Get_All_Paged($page_number);
$sanPham__Get_All = $sp->SanPham__Get_All(1);
?>

<main class="main">
    <div class="main-view-item-container">
        <div class="main-container">
            <div class="main-title-container">
                    <div class="item-title color-2" style="font-weight: bold; font-size: 24px; margin-top: 60px">Tất cả sản phẩm</div>
            </div>
            <div class="main-item-container">
                <?php foreach ($sanPham__Get_Ten_Sp_Paged as $item) : ?>
                    <?php if (count($sanPham__Get_Ten_Sp_Paged) > 0) : ?>
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



        </div>
    </div>

    <div class="pagination-container">
        <div class="pagination">
            <?php
            $total_pages = ceil(count($sanPham__Get_All) / 18);
            // Hiển thị nút đầu trang
            if ($page_number > 1) {
                echo '<a href="index.php?pages=danh-muc&page=1" class="pagination-link">
                        <i class="fas fa-angle-double-left""></i>
                      </a>';
            }

            // Hiển thị nút trước
            if ($page_number > 1) {
                echo '<a href="index.php?pages=danh-muc&page=' . ($page_number - 1) . '" class="pagination-link">
                        <i class="fas fa-angle-left"></i>
                      </a>';
            }

            // Hiển thị các trang gần đó
            for ($i = max(1, $page_number - 2); $i <= min($page_number + 2, $total_pages); $i++) {
                echo '<a href="index.php?pages=danh-muc&page=' . $i . '" class="pagination-link ' . ($page_number == $i ? 'active' : '') . '">' . $i . '</a>';
            }

            // Hiển thị nút sau
            if ($page_number < $total_pages) {
                echo '<a href="index.php?pages=danh-muc&page=' . ($page_number + 1) . '" class="pagination-link">
                          <i class="fas fa-angle-right"></i>
                     </a>';
            }

            // Hiển thị nút cuối trang
            if ($page_number < $total_pages) {
                echo '<a href="index.php?pages=danh-muc&page=' . $total_pages . '" class="pagination-link">
                         <i class="fa fa-angle-double-right""></i>
                     </a>';
            }
            ?>
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
</script>