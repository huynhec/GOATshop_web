<?php
require_once '../../../model/TrangThaiModel.php';
$tt = new TrangThaiModel();
$matt = $_POST['matt'];
$trangThai__Get_By_Id = $tt->TrangThai__Get_By_Id($matt);
?>

<div class="main-update">
    <h3 class="section-title">Cập nhật trạng thái</h3>
    <form class="form-group" action="pages/trang-thai/action.php?req=update" method="post">
        <input type="hidden" class="form-control" id="matt" name="matt" required value="<?= $trangThai__Get_By_Id->matt ?>" readonly>
        <div class="col">
            <label for="tentt" class="form-label">Tên trạng thái</label>
            <input type="text" class="form-control" id="tentt" name="tentt" required value="<?= $trangThai__Get_By_Id->tentt ?>">
        </div>
        <div class="col">
            <label for="mota" class="form-label">Mô tả</label>
            <textarea class="form-control" id="mota" name="mota" required ><?= $trangThai__Get_By_Id->mota ?></textarea>
        </div>
        <br />
        <div class="col text-center">
            <button type="submit" class="btn btn-danger">Cập nhật</button>
            <button type="button" onclick="return location.reload()" class="btn btn-secondary">Hủy</button>
        </div>
    </form>
</div>