<!-- forgot_password.html -->
<div class="auth-container row">

    <div class="form-wrapper col-8">

        <form class="form-control" action="pages/action.php?req=send_reset_link" method="POST">
            <p class="title">Tìm tài khoản của bạn</p>
            <!-- <input type="email" name="email" placeholder="Nhập email của bạn" required> -->
            <div class="input-field">
                <input class="input" type="email" name="email" required />
                <label class="label" for="input">Nhập mail của bạn</label>
            </div>
            <button class="submit-btn" type="submit">Gửi yêu cầu đặt lại mật khẩu</button>
        </form>
    </div>
</div>