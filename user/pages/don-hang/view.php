<?php
require_once '../../../model/ChiTietDonHangModel.php';
require_once '../../../model/SanPhamModel.php';
require_once '../../../model/SizeSpModel.php';
$sp = new SanPhamModel();
$ctdh = new ChiTietDonHangModel();
$szsp = new SizeSpModel();

$madon = $_POST['madon'];
?>
<table class="table-custom" border="1">
    <thead>
        <tr>
            <th>#</th>
            <th>Tên sản phẩm</th>
            <th>Size</th>
            <th>Số lượng</th>
        </tr>
    </thead>
    <tbody>
        <?php $count= 0; 
        foreach ($ctdh->ChiTietDonHang__Get_By_Id_DH($madon) as $item) : ?>
            <tr>
                <td width=2% style="padding: 5px; "><?=++$count?></td>
                <td width="60%" style="padding: 5px; "><?= $sp->SanPham__Get_By_Id($item->masp)->tensp ?></td>
                <td width="20%" style="padding: 5px; "><?= $szsp->SizeSp__Get_By_Id($item->masize)->tensize ?></td>
                <td width="20%" style="padding: 5px; text-align: center"><?= $item->soluong ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>