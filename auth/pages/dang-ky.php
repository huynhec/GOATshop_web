<div class="auth-container row">
    <div class="logo-wrapper col-4">
        <img src="../assets/images/register.jpeg" alt="login" class="img-fluid">
    </div>
    <div class=" form-wrapper col-8">
        <img src="../assets/images/logo-no-background.png" alt="logo" class="img-fluid">
        <h3 class="text-title">Chào mừng bạn mới!</h3>
        <form action="pages/action.php?req=dang-ky" method="post">
            <div class="col">
                <label for="tenkh" class="form-label">Tên khách hàng</label>
                <input type="text" class="form-control" id="tenkh" name="tenkh" required>

                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="row">
                <div class="col">
                    <label for="ngaysinh" class="form-label">Ngày sinh</label>
                    <input type="date" min="<?= date('Y-m-d', strtotime('-100 years')) ?>" max="<?= date('Y-m-d', strtotime('-18 years')) ?>" class="form-control" id="ngaysinh" name="ngaysinh" required>
                </div>
                <div class="col">
                    <label for="gioitinh" class="form-label">Giới tính</label>
                    <select class="form-select " aria-label=".gioitinh" id="gioitinh" name="gioitinh">
                        <option value="0" selected>Nam</option>
                        <option value="1">Nữ</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="col">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="sodienthoai" class="form-label">Số điện thoại</label>
                    <input type="tel" pattern="[0-9]{10}" minlength="10" maxlength="10" class="form-control" id="sodienthoai" name="sodienthoai" required>
                </div>
                <div class="col">
                    <label for="diachi" class="form-label">Địa chỉ</label>
                    <input type="diachi" class="form-control" id="diachi" name="diachi" required>
                </div>
            </div>
            <br>

            <div class="form-group text-center">
                <button class="btn btn-success w-100" type="submit">Signup</button>
            </div>
            <input type="hidden" name="url" id="url" class="form-control" value="<?= $url ?>" />

        </form>
        <hr>
        <p class="footer-text">Bạn đã có tài khoản? <a href="index.php?pages=dang-nhap" class="text-danger">Đăng nhập
                ngay!</a></p>
    </div>
</div>