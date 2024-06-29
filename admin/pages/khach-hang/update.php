<?php
require_once '../../../model/KhachHangModel.php';
require_once '../../../model/UserModel.php';
require_once '../../../model/DiaChiModel.php';

$dc = new DiaChiModel();
$kh = new KhachHangModel();
$user = new UserModel();
$makh = $_POST['makh'];
// Lấy thông tin nhân viên từ bảng khachhang
$khachHang__Get_By_Id = $kh->KhachHang__Get_By_Id($makh);
// Kiểm tra nếu có thông tin khách hàng
if ($khachHang__Get_By_Id) {
    // Lấy mauser từ kết quả của KhachHang__Get_By_Id
    $mauser = $khachHang__Get_By_Id->mauser;
    // Lấy thông tin user từ bảng users bằng mauser
    $user__Get_By_Id = $user->User__Get_By_Id($mauser);
}

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

<div class="main-update">
    <h3 class="section-title">Cập nhật khách hàng</h3>
    <form class="form-group" action="pages/khach-hang/action.php?req=update" method="post">
        <input type="hidden" class="form-control" id="makh" name="makh" required value="<?= $khachHang__Get_By_Id->makh ?>">
        <input type="hidden" class="form-control" id="password_old" name="password_old" value="<?= $user__Get_By_Id->password ?>">
        <input type="hidden" class="form-control" id="email_old" name="email_old" required value="<?= $khachHang__Get_By_Id->email ?>">
        <input type="hidden" class="form-control" id="username_old" name="username_old" required value="<?= $user__Get_By_Id->username ?>">


        <div class="col">
            <label for="tenkh" class="form-label">Tên khách hàng</label>
            <input type="text" class="form-control" id="tenkh" name="tenkh" required value="<?= $khachHang__Get_By_Id->tenkh ?>">
            <label for="tennv" class="form-label">Username</label>
            <input type="text" class="form-control" id="username_new" name="username_new" required value="<?= $user__Get_By_Id->username ?>">
        </div>
        <div class="row">
            <div class="col">
                <label for="ngaysinh" class="form-label">Ngày sinh</label>
                <input type="date" min="<?= date('Y-m-d', strtotime('-100 years')) ?>" max="<?= date('Y-m-d', strtotime('-18 years')) ?>" class="form-control" id="ngaysinh" name="ngaysinh" required value="<?= $khachHang__Get_By_Id->ngaysinh ?>">
            </div>
            <div class="col">
                <label for="gioitinh" class="form-label">Giới tính</label>
                <select class="form-select " aria-label=".gioitinh" id="gioitinh" name="gioitinh">
                    <option value="0" <?= $khachHang__Get_By_Id->gioitinh == 0 ? 'selected' : '' ?>>Nam</option>
                    <option value="1" <?= $khachHang__Get_By_Id->gioitinh == 1 ? 'selected' : '' ?>>Nữ</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email_new" name="email_new" required value="<?= $khachHang__Get_By_Id->email ?>">
            </div>
            <div class="col">
                <label for="password_new" class="form-label">Password</label>
                <input type="password" class="form-control" id="password_new" name="password_new" value="" placeholder="Bỏ qua nếu không đổi mật khẩu">
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="sodienthoai" class="form-label">Số điện thoại</label>
                <input type="tel" pattern="[0-9]{10}" minlength="10" maxlength="10" class="form-control" id="sodienthoai" name="sodienthoai" required value="<?= $khachHang__Get_By_Id->sodienthoai ?>">
            </div>
            <div class="col">
                <label for="trangthai" class="form-label">Trạng thái</label>
                <select class="form-select " aria-label=".trangthai" id="trangthai" name="trangthai">
                    <option value="1" <?= $user__Get_By_Id->trangthai == 1 ? 'selected' : '' ?>>Hoạt động</option>
                    <option value="0" <?= $user__Get_By_Id->trangthai == 0 ? 'selected' : '' ?>>Tạm khóa</option>
                </select>
            </div>
        </div>
        <!-- <div class="col">
            <label for="diachi" class="form-label">Địa chỉ</label>
            <input type="diachi" class="form-control" id="diachi" name="diachi" required value="<?= $khachHang__Get_By_Id->diachi ?>">
        </div> -->
        <br />
        <div class="col text-center">
            <button type="submit" class="btn btn-primary">Lưu thông tin</button>
            <button type="button" onclick="return location.reload()" class="btn btn-secondary">Hủy</button>
        </div>
    </form>

    <!-- địa chỉ -->
    <form class="" method="post">
        <div class="form-group">
            <label for="tinh2">Tỉnh/Thành phố</label>
            <select id="tinh2" name="tinh2" class="form-control" onchange="clear_road();">
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
            <input type="hidden" id="tinh2_name" name="tinh2_name" value="<?php echo $row['name'] ?>">
        </div>
        <div class="form-group">
            <label for="huyen2">Quận/Huyện</label>
            <select id="huyen2" name="huyen2" class="form-control">
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
            <input type="hidden" id="huyen2_name" name="huyen2_name" value="<?php echo $district_cur->name ?>">
        </div>
        <div class="form-group">
            <label for="xa2">Phường/Xã</label>
            <select id="xa2" name="xa2" class="form-control">
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
            <input type="hidden" id="xa2_name" name="xa2_name" value="<?php echo $wards_cur->name ?>">
        </div>
        <div class="form-group">
            <label for="road">Số nhà</label>
            <?php
            $road_cur = $dc->Road__Get_By_Id_Kh($makh);
            ?>

            <input id="road" name="road" class="form-control" value="<?= isset($road_cur->road) ? $road_cur->road : '' ?>">
        </div>

        <br />
        <div class="col text-center">
            <button type="button" class="btn btn-primary" onclick="return checkout()">Lưu địa chỉ</button>
            <button type="button" onclick="return location.reload()" class="btn btn-secondary">Hủy</button>
        </div>
    </form>
</div>
<script src="../assets/js/diachi.js"></script>

<script>
    function clear_road() {
        document.getElementById("road").value = '';
    }

    function checkout() {
            var tinh = document.getElementById('tinh2').options[document.getElementById('tinh2').selectedIndex].text;
            var huyen = document.getElementById('huyen2').options[document.getElementById('huyen2').selectedIndex].text;
            var xa = document.getElementById('xa2').options[document.getElementById('xa2').selectedIndex].text;
            var road = document.getElementById('road').value;

            // Kiểm tra xem các trường đã được điền đầy đủ hay không
            if (tinh.trim() === '' || huyen.trim() === '' || xa.trim() === '' || road.trim() === '') {
                // Nếu có trường nào chưa được điền đầy đủ, hiển thị thông báo lỗi
                alert('Vui lòng điền đầy đủ thông tin.');
                return false;
            }

            $.ajax({
                type: "POST",
                url: "pages/khach-hang/action.php?req=dia-chi", // Thêm '?req=checkout' để gửi action là "checkout"
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
                            location.href = '?pages=khach-hang';
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