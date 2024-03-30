<?php
require_once '../model/SanPhamModel.php';
require_once '../model/DonGiaModel.php';

$dongia = new DonGiaModel();
$sp = new SanPhamModel();
$masp = $_GET['masp'];
$sanPham__Get_By_Id = $sp->SanPham__Get_By_Id($masp);
$dongia__Get_By_Id_Sp_First = $dongia->ShowDonGia__Get_By_Id_Spdg($masp);
?>
<div class="main-add">
    <h3 class="section-title">Thêm đơn giá</h3>
    <form id="chapterForm" class="form-group" action="pages/san-pham/action.php?req=gia_add" method="post"
        enctype="multipart/form-data">
        <input type="hidden" class="form-control" id="masp" name="masp" required value="<?= $masp ?>" readonly>

        <div class="col">
            <label for="anhsp" class="form-label">Thêm đơn giá</label>
            <div class="input-group">
                <input type="text" class="form-control" placeholder="<?=number_format($dongia__Get_By_Id_Sp_First)?> đ" id="dongia" name="dongia[]" multiple>
            </div>
        </div>
        <br />
        <div class="col text-center">
            <button type="submit" class="btn btn-primary" onclick="return update_apdung()">Lưu thông tin</button>
        </div>
    </form>
</div>
<script>
function update_apdung(id_dongia, masp) {
    $.post("pages/san-pham/action.php?req=gia_update", {
        id_dongia: id_dongia,
        masp: masp,
    }, function(data, status) {
        $(".main-form").html(data);
        location.reload();
    });
};
</script>