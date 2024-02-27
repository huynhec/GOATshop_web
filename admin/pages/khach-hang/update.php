<?php
require_once '../../../model/KhachHangModel.php';
require_once '../../../model/UserModel.php';
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
?>

<div class="main-update">
    <h3 class="section-title">Cập nhật khách hàng</h3>
    <form class="form-group" action="pages/khach-hang/action.php?req=update" method="post">
        <input type="hidden" class="form-control" id="makh" name="makh" required value="<?= $khachHang__Get_By_Id->makh ?>">
        <input type="hidden" class="form-control" id="password_old" name="password_old" value="<?= $user__Get_By_Id->password ?>">
        <input type="hidden" class="form-control" id="email_old" name="email_old" required value="<?= $khachHang__Get_By_Id->email ?>">


        <div class="col">
            <label for="tenkh" class="form-label">Tên khách hàng</label>
            <input type="text" class="form-control" id="tenkh" name="tenkh" required value="<?= $khachHang__Get_By_Id->tenkh ?>">
            <label for="tennv" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required value="<?= $user__Get_By_Id->username ?>">
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
                    <option value="1"<?= $user__Get_By_Id->trangthai == 1 ? 'selected' : '' ?>>Hoạt động</option>
                    <option value="0"<?= $user__Get_By_Id->trangthai == 0 ? 'selected' : '' ?>>Tạm khóa</option>
                </select>
            </div>
        </div>
        <div class="col">
            <label for="diachi" class="form-label">Địa chỉ</label>
            <input type="diachi" class="form-control" id="diachi" name="diachi" required value="<?= $khachHang__Get_By_Id->diachi ?>">
        </div>
        <br />
        <div class="col text-center">
            <button type="submit" class="btn btn-primary">Lưu thông tin</button>
        </div>
    </form>
</div>