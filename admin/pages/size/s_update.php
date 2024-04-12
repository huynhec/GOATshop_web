<?php
require_once '../../../model/SizeModel.php';
require_once '../../../model/LoaiSpModel.php';
$size = new SizeModel();
$loaisp = new LoaiSpModel();
$maloai = $_POST['maloai'];
$idsize = $_POST['idsize'];
$size__Get_By_Id = $size->Size__Get_By_Id($idsize);
$maloai = $size__Get_By_Id->maloai;
$size__Get_By_Id_Loai = $size->Size__Get_By_Id_Loai($maloai);
$loai__Get_By_Id = $loaisp->LoaiSp__Get_By_Id($maloai);
$loai__Get_All = $loaisp->LoaiSp__Get_All($maloai);
$size__Get_All = $size->Size__Get_All(-1);

?>


<!-- CSS Bootstrap -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<!-- JS Bootstrap (nếu bạn cần sử dụng các tính năng JavaScript của Bootstrap) -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<div class="main-update">
    <h3 class="section-title">Cập nhật size theo phân loại</h3>
    <form class="form-group" action="pages/size/action.php?req=s_update" method="post">
        <input type="hidden" name="maloai" value="<?= $maloai ?>">


        <div class="col">
            <label>Loại sản phẩm:</label>
            <div class="d-flex align-items-center">
                <h3> <span class="btn btn-primary"><?= $loai__Get_By_Id->tenloai ?></span></h3>
            </div>
        </div>


        <div class="col">
            <?php if (count($size__Get_By_Id_Loai) > 0) : ?>
                <div class="form-check">
                    <div class="row">
                        <?php foreach ($size__Get_By_Id_Loai as $item) : ?>
                            <input type="hidden" id="idsize[]" value="<?= $item->idsize ?>" name="idsize[]" required>
                            <div class="col-8">
                                <label for="tentt" class="form-label">Tên size</label>
                                <input type="text" class="form-control" id="tensize" name="tensize[]" value="<?= $item->tensize ?>" required>
                            </div>
                            <div class="col-4">
                                <label for="trangthai" class="form-label">Trạng thái</label>
                                <select class="form-select " aria-label=".trangthai" id="trangthai" name="trangthai[]">
                                    <option value="1" <?= $item->trangthai == 1 ? "selected" : "" ?>>Hiển thị
                                    </option>
                                    <option value="0" <?= $item->trangthai == 0 ? "selected" : "" ?>>Tạm ẩn
                                    </option>
                                </select>
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