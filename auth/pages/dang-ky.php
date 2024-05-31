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
    <div class=" form-wrapper-1 col-8">
        <a href="../user/index.php">
            <img src="../assets/images/Black logo - no background.png" alt="logo" class="img-fluid" width="300px" style="display: block; margin-left: auto;margin-right: auto; width: 20%;">
        </a>
        <form class="form-control-1" action="pages/action.php?req=dang-ky" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-6">
                    <!-- Left side of the form -->
                    <p class="title">Đăng ký</p>
                    <div class="input-field">
                        <input required="" class="input" type="text" name="tenkh" />
                        <label class="label" for="input">Họ tên</label>
                    </div>

                    <div class="input-field">
                        <input required="" class="input" type="text" name="username" />
                        <label class="label" for="input">Tên đăng nhập</label>
                    </div>

                    <div class="input-field">
                        <input required="" class="input" type="email" name="email" />
                        <label class="label" for="input">Email đăng nhập</label>
                    </div>

                    <div class="input-field">
                        <input required="" class="input" type="password" name="password" />
                        <label class="label" for="input">Mật khẩu</label>
                    </div>


                    <div class="input-field">
                        <input required="" class="input" type="tel" name="sodienthoai" pattern="[0-9]{10}" minlength="10" maxlength="10" />
                        <label class="label" for="input">Số điện thoại</label>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="ngaysinh" class="form-label">Ngày sinh:</label>
                            <input required="" class="input-row" type="date" name="ngaysinh" min="<?= date('Y-m-d', strtotime('-100 years')) ?>" max="<?= date('Y-m-d', strtotime('-18 years')) ?>" />
                        </div>
                        <div class="col">
                            <label for="ngaysinh" class="form-label">Giới tính:</label>
                            <select class="form-select " aria-label=".gioitinh" id="gioitinh" name="gioitinh">
                                <option value="0" selected>Nam</option>
                                <option value="1">Nữ</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="col-6">
                    <!-- Right side of the form -->
                    <p class="title-1">Địa chỉ:</p>

                    <!-- Địa chỉ -->
                    <div class="form-group">
                        <label class="form-label" for="province">Tỉnh/Thành phố</label>
                        <select id="province" name="province" class="form-select">
                            <option value="">Chọn một tỉnh</option>
                            <?php foreach ($results as $row) : ?>
                                <option value="<?php echo $row['province_id'] ?>"><?php echo $row['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <!-- Thêm hidden input để lưu tên tỉnh -->
                        <input type="hidden" id="province_name" name="province_name" value="">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="district">Quận/Huyện</label>
                        <select id="district" name="district" class="form-select">
                            <option value="">Chọn một quận/huyện</option>
                        </select>
                        <!-- Thêm hidden input để lưu tên huyện -->
                        <input type="hidden" id="district_name" name="district_name" value="">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="wards">Phường/Xã</label>
                        <select id="wards" name="wards" class="form-select">
                            <option value="">Chọn một xã</option>
                        </select>
                        <!-- Thêm hidden input để lưu tên xã -->
                        <input type="hidden" id="wards_name" name="wards_name" value="">
                    </div>

                    <div class="input-field">
                        <input required="" id="road" class="input" type="text" name="road" />
                        <label class="label" for="input">Số nhà</label>
                    </div>
                    <br>
                    <div class="g-recaptcha" data-sitekey="6LeCaZkpAAAAADBw3Hip0xBcv6JdGRcEGMQU8HfS"></div>

                </div>
            </div>

            <button class="submit-btn" type="submit">Đăng ký</button>
            <input type="hidden" name="url" id="url" class="form-control" value="<?= $url ?>" />
        </form>
        <hr>
        <p class="footer-text">Bạn đã có tài khoản? <a href="index.php?pages=dang-nhap" class="text-succes">Đăng nhập
                ngay!</a></p>
    </div>
</div>