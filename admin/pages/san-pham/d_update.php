<?php
require_once '../../../model/ThuocTinhModel.php';
require_once '../../../model/SanPhamModel.php';
$sp = new SanPhamModel();
$thuoctinh = new ThuocTinhModel();
$masp = isset($_POST['masp']) ? $_POST['masp'] : 1;
$thuocTinh__Get_By_Id_Sp = $thuoctinh->ThuocTinh__Get_By_Id_Sp($masp);
?>

<div class="col">
    <label>THUỘC TÍNH:</label>
    <?php if (count($thuocTinh__Get_By_Id_Sp) > 0) : ?>
    <div class="form-check">

        <div class="row">

            <?php foreach ($thuocTinh__Get_By_Id_Sp as $item) : ?>

            <div class="col-2">
                <input type="hidden" id="id_cttt<?= $item->id_cttt ?>" value="<?= $item->id_cttt ?>" name="id_cttt[]"
                    required>
                <input type="hidden" id="idtt<?= $item->idtt ?>" value="<?= $item->idtt ?>" name="idtt[]" required>
                <label for="idtt<?= $item->idtt ?>"><?= $item->tentt ?></label>
            </div>
            <div class="col-4">
                <input type="<?= $item->is_num == 1 ? 'number' : 'text' ?>" class="form-control" id="noidung"
                    name="noidung[]" value="<?= $item->noidung ?>" required>

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