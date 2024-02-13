<?php
if (isset($_SESSION['admin'])) {
    unset($_SESSION['admin']);
  }
  if (isset($_SESSION['manager'])) {
    unset($_SESSION['manager']);
  }
  if (isset($_SESSION['nhanvien'])) {
    unset($_SESSION['nhanvien']);
  }
  ?>
<div class="auth-container row">
    <div class="logo-wrapper col-4">
        <img src="../assets/images/loginadmin.jpeg" alt="login" class="img-fluid">
    </div>
    <div class="form-wrapper col-8">
        <img src="../assets/images/logo-no-background.png" alt="logo" class="img-fluid">
        <h3 class="text-title mb-5">ADMIN - LOGIN</h3>
        <form action="pages/action.php?req=dang-nhap-admin" method="post">
            <div class="form-group">
                <label for="email_or_username">Email hoặc Username</label>
                <input type="text" name="email_or_username" id="email_or_username" class="form-control" required
                    placeholder="Nhập email hoặc username">
            </div>
            <div class="form-group">
                <label for="password">Mặt khẩu</label>
                <input type="password" name="password" id="password" class="form-control" required
                    placeholder="Nhập mặt khẩu">
            </div>
            <br>
            <div class="form-group text-center">
                <button class="btn btn-danger w-100" type="submit">Đăng nhập</button>
            </div>
        </form>
    </div>
</div>