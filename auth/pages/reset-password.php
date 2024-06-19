<!-- reset_password -->
<link rel="stylesheet" href="../assets/vendor/boxicons-2.1.4/css/boxicons.min.css">
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
        <a href="../user/index.php">
            <img src="../assets/images/Black logo - no background.png" alt="logo" class="img-fluid" width="300px" style="display: block; margin-left: auto;margin-right: auto; width: 30%;">
        </a>
        <form class="form-control" action="pages/action.php?req=update_password" method="POST" onsubmit="return validatePasswords()">
            <p class="title">Đặt lại mật khẩu của bạn</p>
            <div class="input-field">
                <input type="hidden" name="token" value="<?php echo $_GET['token'] ?? ''; ?>" required>
                <div class="password-wrapper">
                    <input class="input" type="password" name="password" id="password" required />
                    <label class="label" for="password">Nhập mật khẩu mới</label>
                    <span class="eye-icon" onclick="togglePasswordVisibility('password', 'eye-icon-password')">
                        <i id="eye-icon-password" class="bx bx-show"></i>
                    </span>
                </div>
            </div>
            <div class="input-field">
                <div class="password-wrapper">
                    <input class="input" type="password" name="confirm_password" id="confirm_password" required />
                    <label class="label" for="confirm_password">Xác nhận mật khẩu mới</label>
                    <span class="eye-icon" onclick="togglePasswordVisibility('confirm_password', 'eye-icon-confirm')">
                        <i id="eye-icon-confirm" class="bx bx-show"></i>
                    </span>
                </div>
            </div>
            <button class="submit-btn" type="submit">Đặt lại mật khẩu</button>
            <p id="error-message" style="color: red; display: none;">Mật khẩu không khớp. Vui lòng thử lại.</p>
        </form>
    </div>
</div>

<script>
    function validatePasswords() {
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("confirm_password").value;
        var errorMessage = document.getElementById("error-message");

        if (password !== confirmPassword) {
            errorMessage.style.display = "block";
            return false;
        } else {
            errorMessage.style.display = "none";
            return true;
        }
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


