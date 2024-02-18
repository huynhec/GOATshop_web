<?php
if (isset($_GET['pages']) && !isset($_GET['req'])) {
    switch ($_GET['pages']) {
        case "trang-chu":
            require_once "pages/trang-chu/index.php";
            break;
        case "chi-tiet":
            require_once "pages/chi-tiet/index.php";
            break;
        case "gio-hang":
            require_once "pages/gio-hang/index.php";
            break;
        case "don-hang":
            require_once "pages/don-hang/index.php";
            break;
        case "tim-kiem":
            require_once "pages/tim-kiem/index.php";
            break;
        case "thuong-hieu":
            require_once "pages/thuong-hieu/index.php";
            break;
        case "loai-sp":
            require_once "pages/loai-sp/index.php";
            break;
        case "danh-muc":
            require_once "pages/danh-muc/index.php";
            break;
        case "trang-loi":
            require_once "pages/trang-loi/index.php";
            break;
        default:
            // echo "<script>location.href='index.php?pages=trang-loi'</script>";
            break;
    }
} else {
    echo "<script>location.href='index.php?pages=trang-chu'</script>";
}
