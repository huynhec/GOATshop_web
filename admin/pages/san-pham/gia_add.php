<?php
require_once '../model/SanPhamModel.php';
$sp = new SanPhamModel();
$masp = $_GET['masp'];
$sanPham__Get_By_Id = $sp->SanPham__Get_By_Id($masp);
?>
<div class="main-add">
    <h3 class="section-title">Thêm đơn giá</h3>
    <form id="chapterForm" class="form-group" action="pages/san-pham/action.php?req=gia_add" method="post"
        enctype="multipart/form-data">
        <input type="hidden" class="form-control" id="masp" name="masp" required value="<?= $masp ?>" readonly>

        <div class="col">
            <label for="anhsp" class="form-label">Thêm đơn giá</label>
            <div class="input-group">
                <input type="text" class="form-control" id="dongia" name="dongia[]" multiple>
            </div>
        </div>
        <br />
        <div class="col text-center">
            <button type="submit" class="btn btn-primary" onclick="return update_apdung()">Lưu thông tin</button>
        </div>
    </form>
</div>
<script>
// function update_apdung(id_dongia) {
//     DonGia__Update_ApDung($apdung, $id_dongia);
// };
</script>