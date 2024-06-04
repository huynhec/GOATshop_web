<?php
if (isset($_GET['pages']) && !isset($_GET['req'])) {
    switch ($_GET['pages']) {

        case "import-from-excel":
            require_once "pages/import-from-excel/index.php";
            break;
        case "trang-chu":
            require_once "pages/trang-chu/index.php";
            break;
        case "don-hang":
            require_once "pages/don-hang/index.php";
            break;
        case "loai-sp":
            require_once "pages/loai-sp/index.php";
            break;
        case "thuong-hieu":
            require_once "pages/thuong-hieu/index.php";
            break;
        case "thuoc-tinh":
            require_once "pages/thuoc-tinh/index.php";
            break;
        case "size":
            require_once "pages/size/index.php";
            break;
        case "thoi-gian-theo-doi":
            require_once "pages/thoi-gian-theo-doi/index.php";
            break;
        case "luot-xem":
            require_once "pages/luot-xem/index.php";
            break;
        case "trang-thai":
            require_once "pages/trang-thai/index.php";
            break;
        case "khach-hang":
            require_once "pages/khach-hang/index.php";
            break;
        case "nhan-vien":
            require_once "pages/nhan-vien/index.php";
            break;
        case "san-pham":
            require_once "pages/san-pham/index.php";
            break;
        case "anh-san-pham":
            require_once "pages/san-pham/c_index.php";
            break;
        case "dongia-san-pham":
            require_once "pages/san-pham/gia_index.php";
            break;
        case "trang-loi":
            require_once "pages/trang-loi/index.php";
            break;
        default:
            echo "<script>location.href='index.php?pages=trang-loi'</script>";
            break;
    }
} else {
    echo "<script>location.href='index.php?pages=trang-chu'</script>";
}
