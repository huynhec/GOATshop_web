<?php
require_once '../../../model/ThuocTinhModel.php';
require_once '../../../model/SanPhamModel.php';
$sp = new SanPhamModel();
$thuoctinh = new ThuocTinhModel();
$maloai = isset($_POST['maloai']) ? $_POST['maloai'] : 1;
$thuoctinh__Get_By_Id_Loai = $thuoctinh->ThuocTinh__Get_By_Id_Loai($maloai);
$thuoctinh__Get_All = $thuoctinh->ThuocTinh__Get_All(-1);
?>

<div class="col">
    <label>THUỘC TÍNH:</label>
    <?php if (count($thuoctinh__Get_By_Id_Loai) > 0) : ?>
    <div class="form-check">

        <div class="row">

            <?php foreach ($thuoctinh__Get_By_Id_Loai as $item) : ?>

            <div class="col-2">
                <input type="hidden" id="idtt<?= $item->idtt ?>" value="<?= $item->idtt ?>" name="idtt[]" required>
                <label for="idtt<?= $item->idtt ?>"><?= $item->tentt ?></label>
            </div>
            <div class="col-4">
                <input type="<?= $item->is_num == 1 ? 'number' : 'text' ?>" class="form-control" id="noidung"
                    name="noidung[]" required>

            </div>

            <?php endforeach; ?>
        </div>




    </div>
    <?php else : ?>
    <p>
        Không có thuộc tính nào trong phân loại này!

    </p>
    <?php endif ?>
</div>