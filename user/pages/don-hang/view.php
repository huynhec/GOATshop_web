<?php
require_once '../../../model/ChiTietDonHangModel.php';
require_once '../../../model/SanPhamModel.php';
require_once '../../../model/SizeModel.php';
require_once '../../../model/AnhSpModel.php';

$sp = new SanPhamModel();
$ctdh = new ChiTietDonHangModel();
$sz = new SizeModel();
$anhSp = new AnhSpModel();

$madon = $_POST['madon'];
?>
<table class="table-custom" border="1" style=" border-color: black; ">
    <thead>
        <tr>
            <th>#</th>
            <th>Ảnh sản phẩm</th>
            <th>Tên sản phẩm</th>
            <th>Size</th>
            <th>Số lượng</th>
        </tr>
    </thead>
    <tbody>
        <?php $count = 0;
        foreach ($ctdh->ChiTietDonHang__Get_By_Id_DH($madon) as $item) : ?>
            <?php $anhSp__Get_By_Id_Sp_First = $anhSp->AnhSp__Get_By_Id_Sp_First($item->masp); ?>
            <tr>
                <td width="10%" style="padding: 5px; text-align: center"><?= ++$count ?></td>
                <td width="15%" style="padding: 5px; "> <img src="../assets/<?= $anhSp__Get_By_Id_Sp_First->hinhanh ?>" loading="lazy"> </td>
                <td width="45%" style="padding: 5px; "><?= $sp->SanPham__Get_By_Id($item->masp)->tensp ?></td>
                <td width="15%" style="padding: 5px; text-align: center"><?= $sz->Size__Get_By_Id($item->masize)->tensize ?></td>
                <td width="15%" style="padding: 5px; text-align: center"><?= $item->soluong ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>