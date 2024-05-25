<script src="../assets/js/diachi.js"></script>

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
        <br />
        <div class="col text-center">
            <button type="submit" class="btn btn-primary">Lưu thông tin</button>
        </div>
    </form>
</div>