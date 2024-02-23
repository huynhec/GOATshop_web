<?php
require_once '../model/CommonModel.php';
require_once '../model/SanPhamModel.php';
require_once '../model/AnhSpModel.php';
$cm = new CommonModel();
$anhSp = new AnhSpModel();
$sp = new SanPhamModel();
if (!isset($_GET['tu-khoa'])) {
    $sanPham__Get_Ten_Sp_Paged = ["Không tìm thấy sản phẩm này!"];
}
$tu_khoa = $_GET['tu-khoa'];
// Lấy số trang từ tham số truyền vào hoặc mặc định là 1
$page_number = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Lấy danh sách truyện cho trang hiện tại
$sanPham__Get_Ten_Sp_Paged = $sp->SanPham__Get_Ten_Sp_Paged($page_number, $tu_khoa);
?>

<main class="main">
    <div class="main-container">
        <div class="main-title-container">
            <a href="index.php?pages=tim-kiem">
                <div class="item-title color-2"><i class='bx bx-star bx-tada'></i>TÌM KIẾM</div>
            </a>
        </div>
        <div class="main-item-container">
        <?php if (count($sanPham__Get_Ten_Sp_Paged) > 0) : ?>
            <?php foreach ($sanPham__Get_Ten_Sp_Paged as $item) : ?>
                <?php $anhSp__Get_By_Id_Sp_First = $anhSp->AnhSp__Get_By_Id_Sp_First($item->masp); ?>

                    <a href="index.php?pages=chi-tiet&masp=<?= $item->masp ?>">
                        <div class="manga-container">
                            <div class="manga-thumbnail">
                                <img src="../assets/<?= $anhSp__Get_By_Id_Sp_First->hinhanh?>">
                                <span class="manga-note background-2"><?= number_format($item->dongia) ?>đ <i class="bx bxs-star"></i></span>
                            </div>
                            <div class="manga-title color-2"><?= $item->tensp ?></div>
                        </div>
                    </a>
            <?php endforeach ?>
            <?php else: ?>
                Không tìm thấy...
            <?php endif ?>

        </div>
    </div>

    <div class="pagination-container">
        <div class="pagination">
            <?php
            $total_pages = ceil(count($sanPham__Get_Ten_Sp_Paged) / 10);

            // Hiển thị nút đầu trang
            if ($page_number > 1) {
                echo '<a href="index.php?pages=tim-kiem&page=1" class="pagination-link">Đầu trang</a>';
            }

            // Hiển thị nút trước
            if ($page_number > 1) {
                echo '<a href="index.php?pages=tim-kiem&page=' . ($page_number - 1) . '" class="pagination-link">Trang trước</a>';
            }

            // Hiển thị các trang gần đó
            for ($i = max(1, $page_number - 2); $i <= min($page_number + 2, $total_pages); $i++) {
                echo '<a href="index.php?pages=tim-kiem&page=' . $i . '" class="pagination-link ' . ($page_number == $i ? 'active' : '') . '">' . $i . '</a>';
            }

            // Hiển thị nút sau
            if ($page_number < $total_pages) {
                echo '<a href="index.php?pages=tim-kiem&page=' . ($page_number + 1) . '" class="pagination-link">Trang sau</a>';
            }

            // Hiển thị nút cuối trang
            if ($page_number < $total_pages) {
                echo '<a href="index.php?pages=tim-kiem&page=' . $total_pages . '" class="pagination-link">Cuối trang</a>';
            }
            ?>
        </div>
    </div>

</main>