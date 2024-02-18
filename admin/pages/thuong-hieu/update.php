<?php
require_once '../../../model/ThuongHieuModel.php';
$th = new ThuongHieuModel();
$math = $_POST['math'];
$thuongHieu__Get_By_Id = $th->ThuongHieu__Get_By_Id($math);
?>

<div class="main-update">
    <h3 class="section-title">Cập nhật thương hiệu</h3>
    <form class="form-group" action="pages/thuong-hieu/action.php?req=update" method="post">
        <input type="hidden" class="form-control" id="math" name="math" required value="<?= $thuongHieu__Get_By_Id->math ?>" readonly>
        <div class="col">
            <label for="tenth" class="form-label">Tên thương hiệu</label>
            <input type="text" class="form-control" id="tenth" name="tenth" required value="<?= $thuongHieu__Get_By_Id->tenth ?>">
        </div>
        <div class="col">
            <label for="mota" class="form-label">Mô tả</label>
            <textarea class="form-control" id="mota" name="mota" required ><?= $thuongHieu__Get_By_Id->mota ?></textarea>
        </div>
        <div class="col">
                <label for="trangthai" class="form-label">Trạng thái</label>
                <select class="form-select " aria-label=".trangthai" id="trangthai" name="trangthai">
                    <option value="1" <?= $thuongHieu__Get_By_Id->trangthai == 1 ? "selected" : "" ?>>Hiển thị</option>
                    <option value="0" <?= $thuongHieu__Get_By_Id->trangthai == 0 ? "selected" : "" ?>>Tạm ẩn</option>
                </select>
            </div>
        <br />
        <div class="col text-center">
            <button type="submit" class="btn btn-danger">Cập nhật</button>
            <button type="button" onclick="return location.reload()" class="btn btn-secondary">Hủy</button>
        </div>
    </form>
</div>