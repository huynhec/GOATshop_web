<?php
require_once '../../../model/AnhSpModel.php';
require_once '../../../model/SanPhamModel.php';
$anhSp = new AnhSpModel();
$sp = new SanPhamModel();
$maanh = $_POST['maanh'];
$anhSp__Get_By_Id = $anhSp->AnhSp__Get_By_Id($maanh);
$masp = $anhSp__Get_By_Id->masp;
$sanPham__Get_By_Id = $sp->SanPham__Get_By_Id($masp);
?>

<div class="main-update">
    <h3 class="section-title">Cập nhật sp nội dung</h3>
    <form class="form-group" action="pages/san-pham/action.php?req=c_update" method="post" enctype="multipart/form-data">
        <input type="hidden" class="form-control" id="anhsp_cu" name="anhsp_cu" required value="<?=$anhSp__Get_By_Id->anhsp?>" readonly>
        <input type="hidden" class="form-control" id="maanh" name="maanh" required value="<?=$anhSp__Get_By_Id->maanh?>" readonly>
        <input type="hidden" class="form-control" id="masp" name="masp" required value="<?= $masp ?>" readonly>
        <div class="col">
            <label for="c_anhsp" class="form-label">Hình ảnh</label>
            <input accept="image/*" type='file' class="form-control" id="anhsp" name="anhsp">
            <div id="anhsp_preview"><img src="../assets/<?=$anhSp__Get_By_Id->hinhanh ?>" alt="<?= $anhSp__Get_By_Id->maanh ?>" class="img-fluid" width="200"></div>
        </div>
        <div class="col">
            <label for="tensp" class="form-label">Tên sản phẩm</label>
            <input type="text" class="form-control" id="tensp" name="tensp" required value="<?=$sanPham__Get_By_Id->tensp?>" readonly>
        </div>
        <br>
        <div class="col text-center">
            <button type="submit" class="btn btn-primary">Lưu thông tin</button>
            <button type="button" onclick="return location.reload()" class="btn btn-secondary">Hủy</button>
        </div>
    </form>
</div>


<script>

// Lấy ra đối tượng input có id là 'anhsp'
    var anhsp = document.getElementById('anhsp');
    // Lấy ra đối tượng hiển thị ảnh preview có id là 'anhsp_preview'
    var anhsp_preview = document.getElementById('anhsp_preview');

    // Khi giá trị của input 'anhsp' thay đổi
    anhsp.addEventListener('change', function(evt) {
        // Lấy ra mảng các file được chọn trong input
        var [file] = anhsp.files;

        // Kiểm tra xem có file nào được chọn không
        if (file) {
            // Kiểm tra loại MIME của tệp tin
            if (file.type.startsWith('image/')) {
                // Nếu là ảnh, thì hiển thị nó
                var img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.alt = 'anhsp_preview';
                img.style.width = '200px';
                img.style.height = '200px';
                anhsp_preview.innerHTML = '';
                anhsp_preview.appendChild(img);
            } else {
                // Nếu không phải là ảnh, thông báo lỗi
                alert('Vui lòng chọn một tệp tin hình ảnh.');
                // Đặt giá trị của input file về rỗng để xóa tệp đã chọn
                anhsp.value = '';
            }
        }
    });
</script>