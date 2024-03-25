<?php
require_once '../../../model/ThuocTinhModel.php';
require_once '../../../model/LoaiSpModel.php';
$tt = new ThuocTinhModel();
$loaisp = new LoaiSpModel();
$maloai = $_POST['maloai'];
$idtt = $_POST['idtt'];
$thuoctinh__Get_By_Id = $tt->ThuocTinh__Get_By_Id($idtt);
$maloai = $thuoctinh__Get_By_Id->maloai;
$thuoctinh__Get_By_Id_Loai = $tt->ThuocTinh__Get_By_Id_Loai($maloai);
$loai__Get_By_Id = $loaisp->LoaiSp__Get_By_Id($maloai);
$loai__Get_All = $loaisp->LoaiSp__Get_All($maloai);
$thuoctinh__Get_All = $tt->ThuocTinh__Get_All(-1);

?>


<!-- CSS Bootstrap -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<!-- JS Bootstrap (nếu bạn cần sử dụng các tính năng JavaScript của Bootstrap) -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<div class="main-update">
    <h3 class="section-title">Cập nhật thuộc tính theo phân loại</h3>
    <form class="form-group" action="pages/thuoc-tinh/action.php?req=l_update" method="post">
        <input type="hidden" name="maloai" value="<?= $maloai ?>">


        <div class="col">
            <label>Loại sản phẩm:</label>
            <div class="d-flex align-items-center">
                <h3> <span class="btn btn-primary"><?= $loai__Get_By_Id->tenloai ?></span></h3>
            </div>
        </div>


        <div class="col">
            <?php if (count($thuoctinh__Get_By_Id_Loai) > 0) : ?>
                <div class="form-check">
                    <div class="row">
                        <?php foreach ($thuoctinh__Get_By_Id_Loai as $item) : ?>
                            <input type="hidden" id="idtt[]" value="<?= $item->idtt ?>" name="idtt[]" required>
                            <div class="col-8">
                                <label for="tentt" class="form-label">Tên thuộc tính</label>
                                <input type="text" class="form-control" id="tentt" name="tentt[]" value="<?= $item->tentt ?>" required>
                            </div>
                            <div class="col-4">
                                <label for="trangthai" class="form-label">Trạng thái</label>
                                <select class="form-select " aria-label=".trangthai" id="trangthai" name="trangthai[]">
                                    <option value="1" <?= $item->trangthai == 1 ? "selected" : "" ?>>Hiển
                                        thị
                                    </option>
                                    <option value="0" <?= $item->trangthai == 0 ? "selected" : "" ?>>Tạm ẩn
                                    </option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col mt-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input checkbox" type="radio" id="is_num_<?= $item->idtt ?>" value="0" name="is_num_<?= $item->idtt ?>" required <?= $item->is_num == 0 ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="is_num_<?= $item->idtt ?>">Kiểu chữ</label>

                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input checkbox" type="radio" id="is_num_<?= $item->idtt ?>" value="1" name="is_num_<?= $item->idtt ?>" required <?= $item->is_num == 1 ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="is_num_<?= $item->idtt ?>">Kiểu số</label>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif ?>
        </div>
        <br />
        <div class="col text-center">
            <button type="submit" class="btn btn-danger">Cập nhật</button>
            <button type="button" onclick="return location.reload()" class="btn btn-secondary">Hủy</button>
        </div>
    </form>
</div>