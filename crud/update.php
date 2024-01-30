<?php
require_once '../model/UserModel.php';
$user = new UserModel();
$mauser = $_POST['mauser'];
$user__Get_By_Id = $user->User__Get_By_Id($mauser);
?>

<div class="main-update">
    <h3 class="section-title">Cập nhật tài khoản</h3>
    <form class="form-group" action="crud/action.php?req=update" method="post">
        <input type="hidden" class="form-control" id="mauser" name="mauser" required value="<?= $user__Get_By_Id->mauser ?>" readonly>
        <input type="hidden" class="form-control" id="oldpassword" name="oldpassword" required value="<?= $user__Get_By_Id->password?>" readonly>
        <div class="col">
            <label for="ten_hien_thi" class="form-label">Tên hiển thị</label>
            <input type="text" class="form-control" id="tenhienthi" name="tenhienthi" required value="<?= $user__Get_By_Id->tenhienthi ?>">
        </div>
        <div class="col">
            <label for="ten_tai_khoan" class="form-label">Tên tài khoản</label>
            <input type="text" class="form-control" id="username" name="username" required value="<?= $user__Get_By_Id->username ?>">
        </div>
        <div class="col">
            <label for="mat_khau" class="form-label">Mật khẩu</label>
            <input type="password" class="form-control" id="password" name="password" value="" placeholder="Bỏ qua nếu không đổi mật khẩu">
        </div>
        <div class="col">
            <label for="trang_thai" class="form-label">Trạng thái</label>
            <select class="form-select " aria-label=". trang_thai" id="trangthai" name="trangthai">
                <option value="1" <?=$user__Get_By_Id->trangthai == 1 ? "selected" : ""?> >Hoạt động</option>
                <option value="0" <?=$user__Get_By_Id->trangthai == 0 ? "selected" : ""?> >Khóa</option>
            </select>
        </div>
        <div class="col">
            <label for="phan_quyen" class="form-label">Phân quyền</label>
            <select class="form-select " aria-label=". phan_quyen" id="phanquyen" name="phanquyen">
                <option value="1" <?=$user__Get_By_Id->phanquyen == 1 ? "selected" : ""?>>Nhân viên</option>
                <option value="2" <?=$user__Get_By_Id->phan_quyen == 2 ? "selected" : ""?>>Khách hàng</option>
            </select>
        </div>
        <br />
        <div class="col text-center">
            <button type="submit" class="btn btn-primary">Lưu thông tin</button>
            <button type="button" onclick="return location.reload()" class="btn btn-secondary">Hủy</button>
        </div>
    </form>
</div>