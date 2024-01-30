<h3 class="section-title">Thêm mới tài khoản</h3>
<form method="POST" action="./action.php?req=add">
    <div class="mb-3">
        <label for="tenhienthi" class="form-label">Tên hiển thị</label>
        <input type="text" class="form-control" id="tenhienthi" name="tenhienthi" required>
    </div>
    <div class="mb-3">
        <label for="username" class="form-label">Tên tài khoản</label>
        <input type="text" class="form-control" id="username" name="username" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Mật khẩu</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <div class="mb-3">
        <label for="trangthai" class="form-label">Trạng thái</label>
        <select class="form-select" id="trangthai" name="trangthai" required>
            <option value="1">Hoạt động</option>
            <option value="0">Ngừng hoạt động</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary" name="submit">Thêm</button>
</form>

<?php

?>
