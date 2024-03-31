<?php
$a = "./config/connect.php";
$b = "../config/connect.php";
$c = "../../config/connect.php";
$d = "../../../config/connect.php";
$e = "../../../../config/connect.php";
$f = "../../../../../config/connect.php";

if (file_exists($a)) {
    $des = $a;
}
if (file_exists($b)) {
    $des = $b;
}
if (file_exists($c)) {
    $des = $c;
}
if (file_exists($d)) {
    $des = $d;
}

if (file_exists($e)) {
    $des = $e;
}

if (file_exists($f)) {
    $des = $f;
}
include_once($des);

$database = new Database();
$pdo = $database->connect;

// Chuẩn bị và thực thi truy vấn SQL để lấy dữ liệu từ bảng 'province'
try {
    $sql = "SELECT * FROM province";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Lỗi truy vấn: " . $e->getMessage();
    die();
}
?>
<script src="../assets/js/diachi.js"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<div class="auth-container row">
    <div class="logo-wrapper col-4">
        <img src="../assets/images/register.jpeg" alt="login" class="img-fluid">
    </div>
    <div class=" form-wrapper col-8">
        <a href="../user/index.php">
            <img src="../assets/images/logo-no-background.png" style="height:80px;" alt="logo" class="img-fluid">
        </a>
        <h3 class="text-title">Chào mừng bạn mới!</h3>
        <form action="pages/action.php?req=dang-ky" method="post" enctype="multipart/form-data">
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
            </div>
            <!-- Địa chỉ -->
            <div class="form-group">
                <label for="province">Tỉnh/Thành phố</label>
                <select id="province" name="province" class="form-control">
                    <option value="">Chọn một tỉnh</option>
                    <?php foreach ($results as $row) : ?>
                        <option value="<?php echo $row['province_id'] ?>"><?php echo $row['name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <!-- Thêm hidden input để lưu tên tỉnh -->
                <input type="hidden" id="province_name" name="province_name" value="">
            </div>
            <div class="form-group">
                <label for="district">Quận/Huyện</label>
                <select id="district" name="district" class="form-control">
                    <option value="">Chọn một quận/huyện</option>
                </select>
                <!-- Thêm hidden input để lưu tên huyện -->
                <input type="hidden" id="district_name" name="district_name" value="">
            </div>
            <div class="form-group">
                <label for="wards">Phường/Xã</label>
                <select id="wards" name="wards" class="form-control">
                    <option value="">Chọn một xã</option>
                </select>
                <!-- Thêm hidden input để lưu tên xã -->
                <input type="hidden" id="wards_name" name="wards_name" value="">
            </div>


            <div class="form-group">
                <label for="road">Số nhà</label>
                <input id="road" name="road" class="form-control">
            </div>

            <br>
            <div class="g-recaptcha" data-sitekey="6LeCaZkpAAAAADBw3Hip0xBcv6JdGRcEGMQU8HfS"></div>

            <br>

            <div class="form-group text-center">
                <button class="btn btn-success w-100" type="submit">Đăng ký</button>
            </div>
            <input type="hidden" name="url" id="url" class="form-control" value="<?= $url ?>" />

        </form>
        <hr>
        <p class="footer-text">Bạn đã có tài khoản? <a href="index.php?pages=dang-nhap" class="text-danger">Đăng nhập
                ngay!</a></p>
    </div>
</div>