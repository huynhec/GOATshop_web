<?php
require_once '../../../model/SanPhamModel.php';
require_once '../../../model/BannerModel.php';
$sp = new SanPhamModel();
$bn = new BannerModel();
$id_banner = $_POST['id_banner'];
$banner__Get_By_Id = $bn->Banner__Get_By_Id($id_banner);
?>

<div class="main-update">
    <h3 class="section-title">Cập nhật sản phẩm</h3>
    <form class="form-group" action="pages/banner/action.php?req=update" method="post">
        <input type="hidden" class="form-control" id="id_banner" name="id_banner" required value="<?= $banner__Get_By_Id->id_banner ?>">
        <div class="col">
            <label for="tensp" class="form-label">Tên banner</label>
            <input type="text" class="form-control" id="tenbanner" name="tenbanner" required value="<?= $banner__Get_By_Id->tenbanner ?>">
        </div>

        <div class="update-form"></div>

        <div class="col">
            <label for="trangthai" class="form-label">Trạng thái</label>
            <select class="form-select " aria-label=".trangthai" id="trangthai" name="trangthai">
                <option value="1" <?= $banner__Get_By_Id->trangthai == 1 ? "selected" : "" ?>>Hiển thị</option>
                <option value="0" <?= $banner__Get_By_Id->trangthai == 0 ? "selected" : "" ?>>Tạm ẩn</option>
            </select>
        </div>
        <br />
        <div class="col text-center">
            <button type="submit" class="btn btn-primary">Lưu thông tin</button>
            <button type="button" onclick="return location.reload()" class="btn btn-secondary">Hủy</button>
        </div>
    </form>
</div>