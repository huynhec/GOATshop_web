<?PHP
if (isset($_SESSION['user'])) {
    unset($_SESSION['user']);
}
if (isset($_SESSION['url'])) {
    unset($_SESSION['url']);
}

$url = $_SESSION['url'] ?? '../../user/'

?>
<div class="auth-container row">
    <div class="logo-wrapper col-4">
        <img src="../assets/images/login.jpeg" alt="login" class="img-fluid">
    </div>
    <div class="form-wrapper col-8">
        <img src="../assets/images/logo-no-background.png" alt="logo" class="img-fluid">
        <h3 class="text-title mb-5">USER - LOGIN</h3>
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