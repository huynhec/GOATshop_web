<?PHP
if (isset($_SESSION['admin'])) {
    unset($_SESSION['admin']);
}
if (isset($_SESSION['manager'])) {
    unset($_SESSION['manager']);
}
if (isset($_SESSION['nhanvien'])) {
    unset($_SESSION['nhanvien']);
}
if (isset($_SESSION['user'])) {
    unset($_SESSION['user']);
}
if (isset($_SESSION['url'])) {
    unset($_SESSION['url']);
}

if (isset($_SERVER["HTTP_REFERER"])) {
    if (strlen(strstr($_SERVER["HTTP_REFERER"], "dang-nhap")) < 1) {
        if (strlen(strstr($_SERVER["HTTP_REFERER"], "chinh-sua")) < 1) {
            if (strlen(strstr($_SERVER["HTTP_REFERER"], "dang-ky")) < 1) {
                $_SESSION['url'] = $_SERVER["HTTP_REFERER"];
            }
        }
    }
}

$url = $_SESSION['url'] ?? '../../user/';
?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<div class="auth-container row">
    <!-- <div class="logo-wrapper col-4">
        <img src="../assets/images/register.jpeg" alt="login" class="img-fluid">
    </div> -->
    <div class="form-wrapper col-8">
        <a href="../user/index.php">
            <img src="../assets/images/Black logo - no background.png" alt="logo" class="img-fluid" width="300px" style="display: block; margin-left: auto;margin-right: auto; width: 50%;">
        </a><br>
        <h3 class="text-title mb-7">Trang đăng nhập</h3>
        <form action="pages/action.php?req=dang-nhap" method="post">
            <div class="form-group">
                <label for="email_or_username">Email hoặc Username</label>
                <input type="text" name="email_or_username" id="email_or_username" class="form-control" required placeholder="Nhập email hoặc username">
            </div>
            <div class="form-group">
                <label for="password">Mặt khẩu</label>
                <input type="password" name="password" id="password" class="form-control" required placeholder="Nhập mặt khẩu">
            </div>
            <br>
            <div class="g-recaptcha" data-sitekey="6LeCaZkpAAAAADBw3Hip0xBcv6JdGRcEGMQU8HfS"></div>
            <br>
            <div class="form-group text-center">
                <button class="btn btn-primary w-100" type="submit">Đăng nhập</button>
            </div>
            <input type="hidden" name="url" id="url" class="form-control" value="<?= $url ?>" />

        </form>
        <hr>
        <p class="footer-text">Bạn chưa có tài khoản? <a href="index.php?pages=dang-ky" class="text-primary">Đăng ký
                ngay!</a></p>
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
</script>