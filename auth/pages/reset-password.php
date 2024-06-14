<!-- reset_password.html -->
<div class="auth-container row">

    <div class="form-wrapper col-8">

        <form class="form-control" action="pages/action.php?req=update_password" method="POST">
            <p class="title">Đặt lại mật khẩu của bạn</p>
            <div class="input-field">
                <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>" required>
                <input class="input" type="password" name="password" required />
                <label class="label" for="input">Nhập mật khẩu mới</label>
            </div>
            <button class="submit-btn" type="submit">Đặt lại mật khẩu</button>
        </form>
    </div>
</div>