<?php

if (!isset($_SESSION['user'])) {
    header("location: ../../api_auth/?pages=dang-nhap");
    exit();
}
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

require_once '../model/CommonModel.php';
require_once '../model/DiaChiModel.php';
require_once '../model/KhachHangModel.php';


$cm = new CommonModel();
$dc = new DiaChiModel();
$kh = new KhachHangModel();
$makh = isset($_SESSION['user']->makh) ? $_SESSION['user']->makh : 0;
$dc__Get_By_Id_makh = $dc->DiaChi__Get_By_Id($makh);
$khachHang__Get_By_Id = $kh->KhachHang__Get_By_Id($makh);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="dynamicTitle">GOATshop</title>

    <link rel="shortcut icon" href="../assets/images/logo-no-background.ico" type="image/x-icon">
    <link rel="stylesheet" href="../assets/vendor/bootstrap-5.2.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/api_auth.css">
</head>

<body>
    <div class="auth-container row">
        <div class=" form-wrapper-1 col-8">
            <a href="../api/index.php">
                <img src="../assets/images/Black logo - no background.png" alt="logo" class="img-fluid" width="300px" style="display: block; margin-left: auto;margin-right: auto; width: 17%;">
            </a>
            <div class="row">
                <form class="form-control-1" action="pages/action.php?req=chinh-sua" method="post" enctype="multipart/form-data">
                    <div class="col">
                        <!-- Left side of the form -->
                        <p class="title">Thông tin cá nhân</p>
                        <input type="hidden" class="form-control" id="makh" name="makh" required value="<?= $khachHang__Get_By_Id->makh ?>">
                        <input type="hidden" class="form-control" id="password_old" name="password_old" value="<?= $khachHang__Get_By_Id->password ?>">
                        <input type="hidden" class="form-control" id="email_old" name="email_old" required value="<?= $khachHang__Get_By_Id->email ?>">
                        <input type="hidden" class="form-control" id="username_old" name="username_old" required value="<?= $khachHang__Get_By_Id->username ?>">
                        <div class="input-field">
                            <input required="" class="input" type="text" name="tenkh" value="<?= $khachHang__Get_By_Id->tenkh ?>" minlength="8" maxlength="50"/>
                            <label class="label" for="input">Họ tên</label>
                        </div>

                        <div class="input-field">
                            <input required="" class="input" type="text" name="username_new" value="<?= $khachHang__Get_By_Id->username ?? '' ?>" pattern="[a-zA-Z0-9]+" title="Username chỉ cho phép nhập kí tự từ a-z, A-Z, 0-9"  minlength="4" maxlength="20"/>
                            <label class="label" for="input">Tên đăng nhập</label>
                        </div>

                        <div class="input-field">
                            <input required="" class="input" type="email" name="email_new" value="<?= $khachHang__Get_By_Id->email ?>" />
                            <label class="label" for="input">Email đăng nhập</label>
                        </div>

                        <div class="input-field">
                            <input required="" class="input" type="tel" name="sodienthoai" pattern="[0-9]{10}" minlength="10" maxlength="10" value="<?= $khachHang__Get_By_Id->sodienthoai ?>" />
                            <label class="label" for="input">Số điện thoại</label>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="ngaysinh" class="form-label">Ngày sinh:</label>
                                <input required="" class="input-row" type="date" name="ngaysinh" min="<?= date('Y-m-d', strtotime('-100 years')) ?>" max="<?= date('Y-m-d', strtotime('-18 years')) ?>" value="<?= $khachHang__Get_By_Id->ngaysinh ?>" />
                            </div>
                            <div class="col">
                                <label for="ngaysinh" class="form-label">Giới tính:</label>
                                <select class="form-select " aria-label=".gioitinh" id="gioitinh" name="gioitinh">
                                    <option value="0" <?= $khachHang__Get_By_Id->gioitinh == 0 ? 'selected' : '' ?>>Nam</option>
                                    <option value="1" <?= $khachHang__Get_By_Id->gioitinh == 1 ? 'selected' : '' ?>>Nữ</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button class="submit-btn" type="submit">Lưu thông tin</button>
                    <input type="hidden" name="url" id="url" class="form-control" value="<?= $url ?>" />
                </form>
                <form class="form-control-1" method="post">
                    <input type="hidden" class="form-control" id="makh" name="makh" required value="<?= $khachHang__Get_By_Id->makh ?>">
                    <div class="col">
                        <!-- Right side of the form -->
                        <p class="title">Địa chỉ giao hàng</p>
                        <!-- địa chỉ -->
                        <div class="form-group">
                            <label class="form-label" for="tinh">Tỉnh/Thành phố</label>
                            <select id="tinh" name="tinh" class="form-select" onchange="clear_road();">
                                <?php
                                $province_cur = $dc->DiaChi__Get_By_Id_Kh($makh, 'province');
                                ?>
                                <?php if (isset($province_cur->province_id)) : ?>
                                    <option value="<?php echo $province_cur->province_id ?>" selected><?php echo $province_cur->name ?></option>
                                <?php else : ?>
                                    <option value="">Chọn một tỉnh/thành phố</option>

                                <?php endif ?>

                                <?php foreach ($results as $row) : ?>
                                    <?php if ($row['province_id'] != $province_cur->province_id) : ?>
                                        <option value="<?php echo $row['province_id'] ?>"><?php echo $row['name'] ?></option>
                                    <?php endif ?>
                                <?php endforeach; ?>
                            </select>
                            <!-- Thêm hidden input để lưu tên tỉnh -->
                            <input type="hidden" id="tinh_name" name="tinh_name" value="<?php echo $row['name'] ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="huyen">Quận/Huyện</label>
                            <select id="huyen" name="huyen" class="form-select">
                                <?php
                                $district_cur = $dc->DiaChi__Get_By_Id_Kh($makh, 'district');
                                ?>

                                <?php if (isset($district_cur->district_id)) : ?>
                                    <option value="<?php echo $district_cur->district_id ?>" selected><?php echo $district_cur->name ?></option>
                                <?php else : ?>
                                    <option value="">Chọn một quận/huyện</option>
                                <?php endif ?>
                            </select>

                            <!-- Thêm hidden input để lưu tên huyện -->
                            <input type="hidden" id="huyen_name" name="huyen_name" value="<?php echo $district_cur->name ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="xa">Phường/Xã</label>
                            <select id="xa" name="xa" class="form-select">
                                <?php
                                $wards_cur = $dc->DiaChi__Get_By_Id_Kh($makh, 'wards');
                                ?>
                                <?php if (isset($wards_cur->wards_id)) : ?>
                                    <option value="<?php echo $wards_cur->wards_id ?>" selected><?php echo $wards_cur->name ?></option>
                                <?php else : ?>
                                    <option value="">Chọn một xã</option>

                                <?php endif ?>
                            </select>
                            <!-- Thêm hidden input để lưu tên xã -->
                            <input type="hidden" id="xa_name" name="xa_name" value="<?php echo $wards_cur->name ?>">
                        </div>
                        <div class="form-group">
                            <label class="label" for="road">Số nhà</label>
                            <?php
                            $road_cur = $dc->Road__Get_By_Id_Kh($makh);
                            ?>

                            <input id="road" name="road" class="input" value="<?= isset($road_cur->road) ? $road_cur->road : '' ?>">
                        </div>
                        <br>
                        <button type="button" class="submit-btn" onclick="return checkout()">Lưu địa chỉ</button>

                        <input type="hidden" name="url" id="url" class="form-control" value="<?= $url ?>" />

                </form>
            </div>

        </div>

        <hr>
        <p class="footer-text">Mua tiếp nào ! <a href="../api/index.php" class="text-danger">Về trang chủ</a></p>
    </div>
    </div>
    <script>
        function clear_road() {
            document.getElementById("road").value = '';
        }

        function checkout() {
            var tinh = document.getElementById('tinh').options[document.getElementById('tinh').selectedIndex].text;
            var huyen = document.getElementById('huyen').options[document.getElementById('huyen').selectedIndex].text;
            var xa = document.getElementById('xa').options[document.getElementById('xa').selectedIndex].text;
            var road = document.getElementById('road').value;

            // Kiểm tra xem các trường đã được điền đầy đủ hay không
            if (tinh.trim() === '' || huyen.trim() === '' || xa.trim() === '' || road.trim() === '') {
                // Nếu có trường nào chưa được điền đầy đủ, hiển thị thông báo lỗi
                alert('Vui lòng điền đầy đủ thông tin.');
                return false;
            }

            $.ajax({
                type: "POST",
                url: "./pages/action.php?req=dia-chi", // Thêm '?req=checkout' để gửi action là "checkout"
                data: {
                    action: "dia-chi",
                    makh: document.getElementById('makh').value,
                    diachi: `${tinh}, ${huyen}, ${xa}, ${road}`, // Sửa thành cú pháp `${}` để nối các biến
                },
                success: function(response) {
                    console.log(response); // Xác minh phản hồi từ server
                    if (response == true) {
                        Swal.fire({
                            icon: "success",
                            title: "Thay đổi địa chỉ thành công!",
                            confirmButtonText: "OK",
                        }).then((result) => {
                            location.href = '../api/index.php?pages=thong-tin-user';
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Thay đổi địa chỉ thất bại!",
                            text: response, // Hiển thị lỗi từ server nếu có
                            confirmButtonText: "OK"
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error: " + status + " " + error); // Kiểm tra lỗi từ server
                    console.error(xhr.responseText); // Xem phản hồi lỗi chi tiết từ server
                }
            });

        }
    </script>
</body>

</html>