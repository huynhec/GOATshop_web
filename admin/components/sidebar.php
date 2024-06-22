<?php if (isset($_GET['pages'])) : ?>
    <div id="sidebar">
        <div class="sidebar-logo">
            <div class="col-logo">
                <a href="index.php?pages=trang-chu">
                    <img src="../assets/images/Black logo - no background.png" alt="logo">
                </a>
            </div>
            <div class="col-menu" id="menu-bar">
                <i class='bx bx-menu'></i>
            </div>
        </div><br><br><br>
        <ul class="side-menu top">
            <li class="<?= $_GET['pages'] == 'trang-chu' ? "active" : "" ?>">
                <a href="index.php?pages=trang-chu">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Trang chủ</span>
                </a>
            </li>
            <li class="<?= $_GET['pages'] == 'Association-Rules' ? "active" : "" ?>">
                <a href="index.php?pages=Association-Rules">
                    <i class='bx bxs-cog'></i>
                    <span class="text">Training Association Rules</span>
                </a>
            </li>
            <li class="<?= $_GET['pages'] == 'User-Based' ? "active" : "" ?>">
                <a href="index.php?pages=User-Based">
                    <i class='bx bxs-cog'></i>
                    <span class="text">Training User Based</span>
                </a>
            </li>
            <li class="<?= $_GET['pages'] == 'don-hang' ? "active" : "" ?>">
                <a href="index.php?pages=don-hang">
                    <i class='bx bx-file'></i>
                    <span class="text">Quản lý đơn hàng</span>
                </a>
            </li>
            <li class="<?= $_GET['pages'] == 'san-pham' ? "active" : "" ?>">
                <a href="index.php?pages=san-pham">
                    <i class='bx bx-package'></i>
                    <span class="text">Quản lý sản phẩm</span>
                </a>
            </li>
            <li class="<?= $_GET['pages'] == 'loai-sp' ? "active" : "" ?>">
                <a href="index.php?pages=loai-sp">
                    <i class='bx bx-box'></i>
                    <span class="text">Quản lý loại sản phẩm</span>
                </a>
            </li>
            <li class="<?= $_GET['pages'] == 'thuoc-tinh' ? "active" : "" ?>">
                <a href="index.php?pages=thuoc-tinh">
                    <i class='bx bx-list-plus'></i>
                    <span class="text">Quản lý thuộc tính</span>
                </a>
            </li>
            <li class="<?= $_GET['pages'] == 'size' ? "active" : "" ?>">
                <a href="index.php?pages=size">
                    <i class='bx bx-ruler'></i>
                    <span class="text">Quản lý size</span>
                </a>
            </li>
            <li class="<?= $_GET['pages'] == 'banner' ? "active" : "" ?>">
                <a href="index.php?pages=banner">
                    <i class='bx bx-image'></i>
                    <span class="text">Quản lý banner</span>
                </a>
            </li>
            <li class="<?= $_GET['pages'] == 'thuong-hieu' ? "active" : "" ?>">
                <a href="index.php?pages=thuong-hieu">
                    <i class='bx bx-purchase-tag-alt'></i>
                    <span class="text">Quản lý thương hiệu</span>
                </a>
            </li>
            <li class="<?= $_GET['pages'] == 'thoi-gian-theo-doi' ? "active" : "" ?>">
                <a href="index.php?pages=thoi-gian-theo-doi">
                    <i class='bx bx-time'></i>
                    <span class="text">Quản lý thời gian theo dõi</span>
                </a>
            </li>
            <li class="<?= $_GET['pages'] == 'luot-xem' ? "active" : "" ?>">
                <a href="index.php?pages=luot-xem">
                    <i class='bx bx-show'></i>
                    <span class="text">Quản lý lượt xem</span>
                </a>
            </li>

            <?php if (isset($_SESSION['admin'])) : ?>
                <li class="<?= $_GET['pages'] == 'trang-thai' ? "active" : "" ?>">
                    <a href="index.php?pages=trang-thai">
                        <i class='bx bx-stats'></i>
                        <span class="text">Quản lý trạng thái</span>
                    </a>
                </li>
                <li class="<?= $_GET['pages'] == 'nhan-vien' ? "active" : "" ?>">
                    <a href="index.php?pages=nhan-vien">
                        <i class='bx bx-group'></i>
                        <span class="text">Quản lý nhân viên</span>
                    </a>
                </li>
                <li class="<?= $_GET['pages'] == 'khach-hang' ? "active" : "" ?>">
                    <a href="index.php?pages=khach-hang">
                        <i class='bx bx-group'></i>
                        <span class="text">Quản lý khách hàng</span>
                    </a>
                </li>
            <?php endif ?>
            <li>
                <a href="../user/" target="_blank">
                    <i class='bx bx-desktop'></i>
                    <span class="text">Trang người dùng</span>
                </a>
            </li>
            <li>
                <!-- Trang của bạn -->
                <a href="#" class="logout" onclick="confirmLogout()">
                    <i class='bx bxs-log-out-circle'></i>
                    <span class="text">Logout</span>
                </a>
                <script src="../assets/js/confirmLogout.js"></script>


            </li>
        </ul>
    </div>


<?php endif ?>