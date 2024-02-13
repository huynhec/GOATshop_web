<!-- Thêm CSS -->
<link rel="stylesheet" href="../assets/vendor/sweetalert2.min.css">

<!-- Thêm JS -->
<script src="../assets/vendor/sweetalert2.all.min.js"></script>

<?php if (isset($_GET['pages'])) : ?>
    <div id="sidebar">
        <div class="sidebar-logo">
            <div class="col-logo">
                <img src="../assets/images/logo-no-background.png" alt="logo">
            </div>
            <div class="col-menu" id="menu-bar">
                <i class='bx bx-menu'></i>
            </div>
        </div>
        <ul class="side-menu top">
            <li class="<?= $_GET['pages'] == 'trang-chu' ? "active" : "" ?>">
                <a href="index.php?pages=trang-chu">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Trang chủ</span>
                </a>
            </li>
            <li class="<?= $_GET['pages'] == 'don-hang' ? "active" : "" ?>">
                <a href="index.php?pages=don-hang">
                    <i class='bx bx-category-alt'></i>
                    <span class="text">Quản lý đơn hàng</span>
                </a>
            </li>
            <li class="<?= $_GET['pages'] == 'san-pham' ? "active" : "" ?>">
                <a href="index.php?pages=san-pham">
                    <i class='bx bx-category-alt'></i>
                    <span class="text">Quản lý sản phẩm</span>
                </a>
            </li>
            <li class="<?= $_GET['pages'] == 'loai-sp' ? "active" : "" ?>">
                <a href="index.php?pages=loai-sp">
                    <i class='bx bx-category-alt'></i>
                    <span class="text">Quản lý loại sản phẩm</span>
                </a>
            </li>
            <li class="<?= $_GET['pages'] == 'thuong-hieu' ? "active" : "" ?>">
                <a href="index.php?pages=thuong-hieu">
                    <i class='bx bx-category-alt'></i>
                    <span class="text">Quản lý thương hiệu</span>
                </a>
            </li>

            <?php if (isset($_SESSION['admin']) || isset($_SESSION['manager'])) : ?>
                <li class="<?= $_GET['pages'] == 'trang-thai' ? "active" : "" ?>">
                    <a href="index.php?pages=trang-thai">
                        <i class='bx bx-category-alt'></i>
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
                <a href="../user/">
                    <i class='bx bx-desktop'></i>
                    <span class="text">Trang người dùng</span>
                </a>
            </li>
            <li>
                <a href="#" class="logout" onclick="confirmLogout()">
                    <i class='bx bxs-log-out-circle'></i>
                    <span class="text">Logout</span>
                </a>
            </li>
        </ul>
    </div>
<?php endif ?>

<?php
// Kiểm tra xem người dùng nào đang đăng nhập
if (isset($_SESSION['admin'])) {
    $confirmMessage = 'Muốn đăng xuất khỏi trang admin không?';
} elseif (isset($_SESSION['manager'])) {
    $confirmMessage = 'Muốn đăng xuất khỏi trang manager không?';
} elseif (isset($_SESSION['nhanvien'])) {
    $confirmMessage = 'Muốn đăng xuất khỏi trang nhân viên không?';
} else {
    $confirmMessage = 'Muốn đăng xuất không?';
}
?>

<script>
function confirmLogout() {
    // Sử dụng SweetAlert2 thay thế cho hộp thoại confirm
    Swal.fire({
        title: 'Xác nhận đăng xuất',
        text: '<?php echo $confirmMessage; ?>',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Đồng ý',
        cancelButtonText: 'Hủy',
    }).then((result) => {
        // Nếu người dùng đồng ý, thực hiện đăng xuất
        if (result.isConfirmed) {
            window.location.href = "../auth/pages/action.php?req=dang-xuat";
        }
    });
}
</script>

