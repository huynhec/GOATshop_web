<?php
if (isset($_GET['pages']) && !isset($_GET['req'])) {
    switch ($_GET['pages']) {
        case "dang-nhap":
            require_once "pages/dang-nhap.php";
            break;
        case "dang-ky":
            require_once "pages/dang-ky.php";
            break;
        case "quen-mat-khau":
            require_once "pages/quen-mat-khau.php";
            break;
        case "reset-password":
            require_once "pages/reset-password.php";
            break;
        case "chinh-sua":
            require_once "pages/chinh-sua.php";
            break;
        case "notification":
            require_once "pages/notification.php";
            break;
        case "trang-loi":
            require_once "pages/trang-loi.php";
            break;

        default:
            echo "<script>location.href='index.php?pages=trang-loi'</script>";
            break;
    }
} else {
    echo "<script>location.href='index.php?pages=dang-nhap'</script>";
}
