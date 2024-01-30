<?php

require_once '../model/model.php';
$taiKhoan = new Model();


if (isset($_GET['req'])) {
    switch ($_GET['req']) {
        case "login":
            if (isset($_POST["login"])) {
                $username = $_POST["username"];
                $password = $_POST["password"];
                $loginResult = $taiKhoan->Login($username, $password);
                if ($loginResult) {
                    $_SESSION["username"] = $username;
                    $_SESSION["password"] = $password;
                    header("Location: admin.php?=success");
                    exit;
                } else {
                    ?>
                    <script>
                        alert('Tài khoản hoặc mật khẩu sai!');
                        setTimeout(function () {
                            window.location.href = '../pages/login.php';
                        }, 500);
                    </script>
                    <?php
                    // header("location: ../pages/login.php");
                }
            }
            break;
        case "add":
            $res = 0;
            $tenhienthi = $_POST["tenhienthi"];
            $username = $_POST["username"];
            $password = $_POST["password"];
            $trangthai = $_POST["trangthai"];
            $taiKhoan->TaiKhoan__Add($tenhienthi, $username, $password, $trangthai);
            if ($username == $username && $password == $password) {
                $_SESSION["username"] = $username;
                $_SESSION["password"] = $password;
                header("location: ../pages/admin.php?=success");
            }
            break;
    }
}
?>