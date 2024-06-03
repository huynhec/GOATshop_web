<?php
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
<div class="main-add">
    <h3 class="text-title">Thêm khách hàng</h3>
    <form class="form-group" action="pages/khach-hang/action.php?req=add" method="post">
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
                <label for="trangthai" class="form-label">Trạng thái</label>
                <select class="form-select " aria-label=".trangthai" id="trangthai" name="trangthai">
                    <option value="1" selected>Hoạt động</option>
                    <option value="0">Tạm khóa</option>
                </select>
            </div>
        </div>
        <!-- Địa chỉ -->
        <div class="form-group">
            <label for="tinh1">Tỉnh/Thành phố</label>
            <select id="tinh1" name="tinh1" class="form-control">
                <option value="">Chọn một tỉnh</option>
                <?php foreach ($results as $row) : ?>
                    <option value="<?php echo $row['province_id'] ?>"><?php echo $row['name'] ?></option>
                <?php endforeach; ?>
            </select>
            <!-- Thêm hidden input để lưu tên tỉnh -->
            <input type="hidden" id="tinh1_name" name="tinh1_name" value="">
        </div>
        <div class="form-group">
            <label for="huyen1">Quận/Huyện</label>
            <select id="huyen1" name="huyen1" class="form-control">
                <option value="">Chọn một quận/huyện</option>
            </select>
            <!-- Thêm hidden input để lưu tên huyện -->
            <input type="hidden" id="huyen1_name" name="huyen1_name" value="">
        </div>
        <div class="form-group">
            <label for="xa1">Phường/Xã</label>
            <select id="xa1" name="xa1" class="form-control">
                <option value="">Chọn một xã</option>
            </select>
            <!-- Thêm hidden input để lưu tên xã -->
            <input type="hidden" id="xa1_name" name="xa1_name" value="">
        </div>

        <div class="form-group">
            <label for="road">Số nhà</label>
            <input id="road" name="road" class="form-control">
        </div>
        <br />
        <div class="col text-center">
            <button type="submit" class="btn btn-primary">Lưu thông tin</button>
        </div>
    </form>
</div>