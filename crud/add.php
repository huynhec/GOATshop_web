
<div class="main-add">
    <h3 class="section-title">Thêm tài khoản</h3>
    <form class="form-group" action="crud/action.php?req=add" method="post">
        <div class="col">
            <label for="ten_hien_thi" class="form-label">Tên hiển thị</label>
            <input type="text" class="form-control" id="tenhienthi" name="tenhienthi" required>
        </div>
        <div class="col">
            <label for="ten_tai_khoan" class="form-label">Tên tài khoản</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="col">
            <label for="mat_khau" class="form-label">Mật khẩu</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="col">
            <label for="trang_thai" class="form-label">Trạng thái</label>
            <select class="form-select " aria-label="trang_thai" id="trangthai" name="trangthai">
                <option value="1" selected>Hoạt động</option>
                <option value="0">Khóa</option>
            </select>
        </div>
        <div class="col">
            <label for="phan_quyen" class="form-label">Phân quyền</label>
            <select class="form-select " aria-label="phan_quyen" id="phanquyen" name="phanquyen">
                <option value="1" selected>Nhân viên</option>
                <option value="2">Khách hàng</option>
            </select>
        </div>
        <br />
        <div class="col text-center">
            <button type="submit" class="btn btn-primary">Lưu thông tin</button>
        </div>
    </form>
</div>











<style>
    /* styles.css */

.main-add {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin: 20px auto;
    max-width: 600px;
}

.section-title {
    color: #007bff;
}

.form-group {
    margin-top: 20px;
}

.form-label {
    font-weight: bold;
    margin-bottom: 5px;
    display: block;
}

.form-control {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.form-select {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.btn-primary {
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.btn-primary:hover {
    background-color: #0056b3;
}

</style>