<?PHP

if (isset($_SERVER["HTTP_REFERER"])) {
    // Kiểm tra xem "dang-nhap" không xuất hiện trong HTTP referer
    if (strlen(strstr($_SERVER["HTTP_REFERER"], "dang-nhap")) < 1) {
        // Kiểm tra xem "chinh-sua" không xuất hiện trong HTTP referer
        if (strlen(strstr($_SERVER["HTTP_REFERER"], "chinh-sua")) < 1) {
            // Kiểm tra xem "dang-ky" không xuất hiện trong HTTP referer
            if (strlen(strstr($_SERVER["HTTP_REFERER"], "dang-ky")) < 1) {
                // Kiểm tra xem "quen-mat-khau" không xuất hiện trong HTTP referer
                if (strlen(strstr($_SERVER["HTTP_REFERER"], "quen-mat-khau")) < 1) {
                    // Nếu không có điều kiện nào được thỏa mãn, gán $_SESSION['url'] bằng HTTP referer
                    $_SESSION['url'] = $_SERVER["HTTP_REFERER"];
                }
            }
        }
    }
}

// Gán $url bằng $_SESSION['url'], mặc định là '../../api/' nếu $_SESSION['url'] không được set
$url = $_SESSION['url'] ?? '../../api/';

?>
<link rel="stylesheet" href="../assets/vendor/boxicons-2.1.4/css/boxicons.min.css">
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<style>
    .password-wrapper {
        position: relative;
    }

    .eye-icon {
        position: absolute;
        right: 10px;
        top: 65%;
        transform: translateY(-50%);
        cursor: pointer;
    }
</style>
<div class="auth-container row">
    <div class="form-wrapper col-8">
        <a href="../api/index.php">
            <img src="../assets/images/Black logo - no background.png" alt="logo" class="img-fluid">
        </a>
        <form class="form-control" action="pages/action.php?req=dang-nhap" method="post">
            <p class="title">Đăng nhập</p>
            <div class="input-field">
                <input required="" id="password" class="input" type="text" name="email_or_username" minlength="4" maxlength="254" />
                <label class="label" for="input">Email hoặc username</label>
                <span class="eye-icon" onclick="togglePasswordVisibility('password', 'eye-icon-password')">
                    <i id="eye-icon-password" class="bx bx-show"></i>
                </span>
            </div>
            <div class="input-field">
                <input required="" class="input" type="password" name="password" minlength="6" maxlength="20" />
                <label class="label" for="input">Mật khẩu</label>
            </div>
            <div class="g-recaptcha" data-sitekey="6LeCaZkpAAAAADBw3Hip0xBcv6JdGRcEGMQU8HfS"></div>
            <a href="index.php?pages=quen-mat-khau">Quên mật khẩu?</a>
            <button class="submit-btn" type="submit">Đăng nhập</button>
            <input type="hidden" name="url" id="url" class="form-control" value="<?= $url ?>" />
        </form>

        <hr>
        <p class="footer-text">Bạn chưa có tài khoản? <a href="index.php?pages=dang-ky" class="text-primary">Đăng ký ngay!</a></p>
    </div>
</div>

<script>
    function onClick(e) {
        e.preventDefault();
        grecaptcha.enterprise.ready(async () => {
            const token = await grecaptcha.enterprise.execute('6Lf6YJkpAAAAAF-ubij-CHecYIxiqmrM32oB8CuN', {
                action: 'LOGIN'
            });
        });
    }
    function togglePasswordVisibility(inputId, iconId) {
        var input = document.getElementById(inputId);
        var icon = document.getElementById(iconId);
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("bx-show");
            icon.classList.add("bxs-show");
        } else {
            input.type = "password";
            icon.classList.remove("bxs-show");
            icon.classList.add("bx-show");
        }
    }
</script>