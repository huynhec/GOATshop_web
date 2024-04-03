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
                <input type="text" class="form-control" placeholder="<?=number_format($dongia__Get_By_Id_Sp_First)?> ₫" id="dongia" name="dongia[]" multiple required>
            </div>
        </div>
        <br />
        <div class="col text-center">
            <button type="submit" class="btn btn-primary">Lưu thông tin</button>
        </div>
    </form>
</div>
<script>
// function update_send(id_dongia, masp) {
//     // Kiểm tra xem ô input có giữ liệu không
//     var dongiaInput = $("#dongia");
//     if (dongiaInput.val().trim() !== '') {
//         // Nếu ô input có giữ liệu, thực hiện gửi dữ liệu lên server
//         $.post("pages/san-pham/action.php?req=gia_update", {
//             id_dongia: id_dongia,
//             masp: masp,
//         }, function(data, status) {
//             $(".main-form").html(data);
//             location.reload();
//             location.href = "index.php?pages=san-pham#product_" + masp;

//         });
//     } else {
//         // Nếu ô input không có giữ liệu, thực hiện hành động tương ứng
//         // Ví dụ: Hiển thị thông báo lỗi, không thực hiện gì cả, vv.
//         header("location: ../../index.php?pages=san-pham&msg=error");
//     }
// }

</script>