<?php
require_once '../../../model/ThuocTinhModel.php';
require_once '../../../model/LoaiSpModel.php';
$tt = new ThuocTinhModel();
$loaisp = new LoaiSpModel();
$idtt = $_POST['idtt'];
$thuoctinh__Get_By_Id = $tt->ThuocTinh__Get_By_Id($idtt);
$maloai = $thuoctinh__Get_By_Id->maloai;
$loai__Get_By_Id = $loaisp->LoaiSp__Get_By_Id($maloai);
$loai__Get_All = $loaisp->LoaiSp__Get_All($maloai);
?>

<!-- CSS Bootstrap -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<!-- JS Bootstrap (nếu bạn cần sử dụng các tính năng JavaScript của Bootstrap) -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<div class="main-update">
    <h3 class="section-title">Cập nhật thuộc tính</h3>
    <form class="form-group" action="pages/thuoc-tinh/action.php?req=update" method="post">
        <input type="hidden" class="form-control" id="idtt" name="idtt" required value="<?= $thuoctinh__Get_By_Id->idtt ?>" readonly>

        <div class="col">
            <label>Loại sản phẩm:</label>
            <?php foreach ($loai__Get_All as $item) : ?>
                <?php if ($item->maloai == $thuoctinh__Get_By_Id->maloai) : ?>
                    <div class="d-flex align-items-center">
                        <h3> <span class="btn btn-primary"><?= $item->tenloai ?></span></h3>
                    </div>
                    <input type="hidden" name="maloai" value="<?= $item->maloai ?>">
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <div class="col">
            <label for="tentt" class="form-label">Tên thuộc tính</label>
            <input type="text" class="form-control" id="tentt" name="tentt" required value="<?= $thuoctinh__Get_By_Id->tentt ?>">
        </div>

        <div class="col">
            <label for="trangthai" class="form-label">Trạng thái</label>
            <select class="form-select " aria-label=".trangthai" id="trangthai" name="trangthai">
                <option value="1" <?= $thuoctinh__Get_By_Id->trangthai == 1 ? "selected" : "" ?>>Hiển thị</option>
                <option value="0" <?= $thuoctinh__Get_By_Id->trangthai == 0 ? "selected" : "" ?>>Tạm ẩn</option>
            </select>
        </div>

        <div class="col mt-2">
            <div class="form-check form-check-inline">
                <input class="form-check-input checkbox" type="radio" id="is_num_0" value="0" name="is_num" required <?= $thuoctinh__Get_By_Id->is_num == 0 ? 'checked' : '' ?>>
                <label class="form-check-label" for="is_num_0">Kiểu chữ</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input checkbox" type="radio" id="is_num_1" value="1" name="is_num" required <?= $thuoctinh__Get_By_Id->is_num == 1 ? 'checked' : '' ?>>
                <label class="form-check-label" for="is_num_1">Kiểu số</label>
            </div>
        </div>
        <br />
        <div class="col text-center">
            <button type="submit" class="btn btn-danger">Cập nhật</button>
            <button type="button" onclick="return location.reload()" class="btn btn-secondary">Hủy</button>
        </div>
    </form>
</div>