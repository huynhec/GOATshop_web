<?php
require_once "../model/LoaiSpModel.php";
require_once "../model/ThuongHieuModel.php";
require_once "../model/ChiTietGioHangModel.php";
require_once "../model/GioHangModel.php";
$loaisp = new LoaiSpModel();
$th = new ThuongHieuModel();
$ctgh = new ChiTietGioHangModel();
$gh = new GioHangModel();
// Lấy danh sách thể loại
$loaiSp__Get_All = $loaisp->LoaiSp__Get_All();
$thuongHieu__Get_All = $th->ThuongHieu__Get_All();
?>
<style>
    .nav-icons {
        display: flex;
        gap: 15px;
    }

    .nav-icon {
        color: #fff;
        font-size: 18px;
        text-decoration: none;
    }

    .nav-icon:hover {
        color: #f90;
    }
</style>

<!-- Thẻ chứa thanh điều hướng -->
<nav class="navbar">
    <!-- Thẻ chứa nội dung thanh điều hướng -->
    <div class="navbar-container">
        <!-- Phần bên trái thanh điều hướng -->
        <div class="navbar-logo-menu">
            <!-- Logo -->
            <a class="navbar-logo" href="./index.php">
                <img alt="logo" src="../assets/images/White logo - no background.png">
            </a>
            <!-- Nút điều hướng trên điện thoại -->
            <div class="navbar-toggle"><i class="bx bx-menu"></i></div>
            <!-- Menu điều hướng -->
            <div class="navbar-menu">
                <!-- Ô tìm kiếm -->
                <div class="navbar-search">
                    <input id="search-box" type="text" name="search" autocomplete="off" placeholder="Tìm kiếm sản phẩm">
                    <div class="icon">
                        <i class="fas fa-search"></i>
                    </div>
                </div>
                <!-- Danh sách -->
                <div class="navbar-item has-sub">
                    <a href="index.php?pages=danh-muc">Danh mục<i class="fas fa-chevron-down"></i></a>
                    <ul class="navbar-item-sub">
                        <div class="menu-genre">
                            <?php foreach ($loaiSp__Get_All as $item) : ?>
                                <li>
                                    <a href="index.php?pages=loai-sp&maloai=<?= $item->maloai ?>">
                                        - <?= $item->tenloai ?>
                                    </a>
                                </li>
                            <?php endforeach ?>
                        </div>
                    </ul>
                </div>
                <div class="navbar-item has-sub">
                    <a href="index.php?pages=thuong-hieu">Thương hiệu<i class="fas fa-chevron-down"></i></a>
                    <ul class="navbar-item-sub">
                        <div class="menu-genre">
                            <?php foreach ($thuongHieu__Get_All as $item) : ?>
                                <li><a href="index.php?pages=thuong-hieu&math=<?= $item->math ?>">- <?= $item->tenth ?></a></li>
                            <?php endforeach ?>
                        </div>
                    </ul>
                </div>

                <!--  -->
                <?php if (isset($_SESSION['user'])) : ?>

                    <div class="navbar-item"><a href="index.php?pages=don-hang"><i class='bx bxs-file bx-burst' style='color:#ff0004'></i>Đơn của bạn</a></div>

                <?php endif ?>
                <!-- Nút đóng menu -->
                <div class="navbar-close">
                    <i class="bx bx-x"></i>
                </div>
            </div>
        </div>
        <!-- Phần bên phải thanh điều hướng -->

        <div class="navbar-display-user-action">
            <?php if (isset($_SESSION['user'])) : ?>
                <div class="navbar-display-cart" onclick="return(location.href='./index.php?pages=gio-hang')">
                    <i class="fas fa-shopping-cart">
                        <!-- <i class='bx bxs-cart'> -->
                        <?php
                        $res = 0;
                        if (isset($_SESSION['user'])) {
                            $magh = isset($gh->GioHang__Get_By_Id_Kh($_SESSION['user']->makh)->magh) ? $gh->GioHang__Get_By_Id_Kh($_SESSION['user']->makh)->magh : 0;
                            $res = count($ctgh->ChiTietGioHang__Get_By_Id_GH($magh));
                        }
                        ?>
                        <span id="cart-item">(<?= ($res) ?>)</span>
                    </i>
                </div>

            <?php else : ?>
                <a href="../auth?pages=dang-nhap">
                    <div class="navbar-display-cart">
                        <i class="fas fa-shopping-cart">
                            <span id="cart-item">(0)</span>
                        </i>
                    </div>
                </a>
                <!-- <div class="navbar-display-cart" onclick="return checkLogin()">
                    <i class="fas fa-shopping-cart">
                        <span id="cart-item">(0)</span>
                    </i>
                </div> -->
            <?php endif ?>

            <?php if (isset($_SESSION['user'])) : ?>
                <!-- display-user người dùng đã đăng nhập -->
                <div class="navbar-display-user">
                    <!-- <i class='bx bxs-user-detail'></i> -->
                    <i class="fas fa-user"></i>
                </div>
                <!-- Menu hành động của người dùng -->
                <div class="navbar-display-action hidden">
                    <a href="#">
                        <li><b><i class='bx bx-user-check'></i><?= $_SESSION['user']->tenkh ?></b></li>
                    </a>
                    <!-- <a href="index.php?pages=san-phan-da-xem">
                        <li> <i class='bx bx-book-reader'></i> Sản phẩm đã xem</li>
                    </a> -->
                    <!-- <a href="index.php?pages=san-phan-da-thich">
                        <li> <i class='bx bx-book-heart'></i> Sản phẩm đã thích</li>
                    </a> -->
                    <!-- <a href="index.php?pages=san-phan-theo-doi">
                        <li><i class='bx bx-book-bookmark'></i> Đang theo dõi</li>
                    </a> -->
                    <hr>
                    <a href="#../auth/pages/chinh-sua.php">
                        <li> <i class='bx bx-cog'></i> Chỉnh sửa</li>
                    </a>
                    <hr>
                    <a href="../auth/pages/action.php?req=dang-xuat">
                        <li><i class='bx bx-log-out'></i> Đăng xuất</li>
                    </a>
                </div>
            <?php else : ?>
                <!-- display-user người dùng chưa đăng nhập -->
                <div class="navbar-display-user">
                    <!-- <i class="bx bx-user"></i> -->
                    <a href="../auth?pages=dang-nhap"><i class="fas fa-user"></i></a></i>

                </div>
                <!-- Menu hành động khi chưa đăng nhập -->
                <div class="navbar-display-action hidden">
                    <li><i class='bx bx-log-in'></i> <a href="../auth?pages=dang-nhap">Đăng nhập</a></li>
                </div>
            <?php endif ?>
        </div>
    </div>
</nav>


<!-- Nút hành động nổi -->
<div class="floating-action">
    <!-- Nút chuyển đổi tìm kiếm -->
    <div class="action-item action-toggle"><i class="bx bx-target-lock"></i></div>
    <!-- Nút trang chủ -->
    <div class="action-item action-home"><i class="bx bx-home"></i></div>
    <!-- Nút menu -->
    <div class="action-item action-menu"><i class="bx bx-menu"></i></div>
    <!-- Nút người dùng -->
    <div class="action-item action-user"><i class="bx bx-user"></i></div>
    <!-- Nút lên đầu trang -->
    <!-- <div class="action-item action-top"><i class="bx bx-chevron-up"></i></div> -->
</div>

<div id="fixed-social-network">
    <a href="https://www.facebook.com/profile.php?id=61560199895202" target="_blank" class="fb-icon"><i class="fa fa-facebook" aria-hidden="true"></i></a>
    <a href="https://www.instagram.com/huynhnguyen3543/" target="_blank" class="ins-icon"><i class="fa fa-instagram" aria-hidden="true"></i></a>
    <a href="https://www.tiktok.com/@hsifootball" target="_blank" class="tiktok-icon"><img src="https://file.hstatic.net/200000397757/file/tik-tok_b0606ed7c66a49258e7f86647843b718.svg"></a>
    <a href="https://www.youtube.com/@hsifootball6898/videos" target="_blank" class="yt-icon"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>
</div>


<div id="fixed-contact">
    <a href="tel:+0985259052" class="call-icon"><i class="fa fa-phone" aria-hidden="true"></i></a>
    <!-- <a href="https://www.google.com/maps?q=location" target="_blank" class="location-icon"><i class="fa fa-map-marker" aria-hidden="true"></i></a> -->
    <a href="https://www.facebook.com/messages/t/342366168954879" target="_blank" class="messenger-icon"><i class="fa fa-facebook-messenger" aria-hidden="true"></i></a>
    <a href="#" class="back-to-top action-top"><i class="fa fa-angle-up" aria-hidden="true"></i></a>
    <!-- <div class="action-item action-toggle"><i class="bx bx-target-lock"></i></div> -->

</div>