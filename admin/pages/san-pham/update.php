<?php
require_once '../../../model/SanPhamModel.php';
require_once '../../../model/ThuongHieuModel.php';
require_once '../../../model/LoaiSpModel.php';
$loaiSp = new LoaiSpModel();
$sp = new SanPhamModel();
$th = new ThuongHieuModel();
$masp = $_POST['masp'];
$maloai = $_POST['maloai'];
$sanPham__Get_By_Id = $sp->SanPham__Get_By_Id($masp);
$thuongHieu__Get_All = $th->ThuongHieu__Get_All();
$loaiSp__Get_All = $loaiSp->loaiSp__Get_All();
$loaiSp_Get_By_Id = $loaiSp->LoaiSp__Get_By_Id($maloai);
?>

<div class="main-update">
    <h3 class="section-title">Cập nhật sản phẩm</h3>
    <form class="form-group" action="pages/san-pham/action.php?req=update" method="post">
        <input type="hidden" class="form-control" id="masp" name="masp" required
            value="<?= $sanPham__Get_By_Id->masp ?>">
        <div class="col">
            <label for="tensp" class="form-label">Tên sản phẩm</label>
            <input type="text" class="form-control" id="tensp" name="tensp" required
                value="<?= $sanPham__Get_By_Id->tensp ?>">
        </div>

        <div class="col">
            <label>Chọn thương hiệu:</label>
            <?php foreach ($thuongHieu__Get_All as $item) : ?>
            <div class="form-check form-check-inline">
                <input class="btn-check" type="radio" id="math<?= $item->math ?>" value="<?= $item->math ?>" name="math"
                    <?= $item->math == $sanPham__Get_By_Id->math ? 'checked' : '' ?>>
                <label class="btn btn-outline-primary" for="math<?= $item->math ?>"><?= $item->tenth ?></label>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="col">
            <label>Loại sản phẩm:</label>
            <div class="form-check form-check-inline">
                <input class="btn-check" type="radio" id="maloai<?= $maloai ?>" value="<?= $maloai ?>"
                    name="maloai" <?= $maloai == $sanPham__Get_By_Id->maloai ? 'checked' : '' ?>
                    <?= $maloai == $sanPham__Get_By_Id->maloai ? "onclick='d_update_obj()'" : "onclick='d_add_obj(`$item->maloai`)'" ?>>
                <label class="btn btn-outline-primary" for="maloai<?= $maloai ?>"><?=$loaiSp_Get_By_Id->tenloai  ?></label>
            </div>
        </div>
        <div class="update-form"></div>

        <div class="col">
            <label for="trangthai" class="form-label">Trạng thái</label>
            <select class="form-select " aria-label=".trangthai" id="trangthai" name="trangthai">
                <option value="1" <?= $sanPham__Get_By_Id->trangthai == 1 ? "selected" : "" ?>>Hiển thị</option>
                <option value="0" <?= $sanPham__Get_By_Id->trangthai == 0 ? "selected" : "" ?>>Tạm ẩn</option>
            </select>
        </div>

        <div class="col">
            <label for="mota" class="form-label">Mô tả</label>
            <textarea class="form-control" id="mota_u" name="mota"><?= $sanPham__Get_By_Id->mota ?></textarea>
        </div>

        <div class="col">
            <label for="luotmua" class="form-label">Lượt mua</label>
            <input type="number" min="0" max="1000000000" class="form-control" id="luotmua" name="luotmua" required
                value="<?= $sanPham__Get_By_Id->luotmua ?>" readonly>
        </div>
        <br />
        <div class="col text-center">
            <button type="submit" class="btn btn-primary">Lưu thông tin</button>
            <button type="button" onclick="return location.reload()" class="btn btn-secondary">Hủy</button>
        </div>
    </form>
</div>
<script>
d_update_obj();

CKEDITOR.replace('mota_u');

function d_update_obj() {
    $.post("pages/san-pham/d_update.php", {
        masp: <?= $masp ?>
    }, function(data, status) {
        $(".update-form").html(data);
    });
};

function d_add_obj(maloai) {
    $.post("pages/san-pham/d_add.php", {
        maloai: maloai,
    }, function(data, status) {
        $(".update-form").html(data);
    });
};
</script>