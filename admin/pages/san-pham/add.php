<?php
require_once '../model/ThuongHieuModel.php';
require_once '../model/LoaiSpModel.php';
$th = new ThuongHieuModel();
$loaiSp = new LoaiSpModel();
$thuongHieu__Get_All = $th->ThuongHieu__Get_All();
$loaiSp__Get_All = $loaiSp->LoaiSp__Get_All();
?>
<div class="main-add">
    <h3 class="section-title">Thêm sản phẩm</h3>
    <form class="form-group" action="pages/san-pham/action.php?req=add" method="post" enctype="multipart/form-data">
        <div class="col">
            <label for="tensp" class="form-label">Tên sản phẩm</label>
            <input type="text" class="form-control" id="tensp" name="tensp" required>
        </div>

        <div class="row">
            <div class="col">
                <label for="dongia" class="form-label">Đơn giá</label>
                <input type="number" min="0" max="1000000000" class="form-control" id="dongia" name="dongia" required>
            </div>
            <div class="col">
                <label for="trangthai" class="form-label">Trạng thái</label>
                <select class="form-select " aria-label=".trangthai" id="trangthai" name="trangthai">
                    <option value="1" selected>Hiển thị</option>
                    <option value="0">Tạm ẩn</option>
                </select>
            </div>
        </div>
        <div class="col">
            <label>Chọn thương hiệu:</label>
            <?php foreach ($thuongHieu__Get_All as $item) : ?>
                <div class="form-check form-check-inline">
                    <input class="form-check-input checkbox" type="radio" id="math<?= $item->math ?>" value="<?= $item->math ?>" name="math" required>
                    <label class="form-check-label" for="math<?= $item->math ?>"><?= $item->tenth ?></label>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="col">
            <label>Chọn loại sản phẩm:</label>
            <?php foreach ($loaiSp__Get_All as $item) : ?>
                <div class="form-check form-check-inline">
                    <input class="form-check-input checkbox" type="radio" id="maloai<?= $item->maloai ?>" value="<?= $item->maloai ?>" name="maloai" required>
                    <label class="form-check-label" for="maloai<?= $item->maloai ?>"><?= $item->tenloai ?></label>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="col">
            <label for="mota" class="form-label">Mô tả</label>
            <textarea class="form-control" id="mota" name="mota"></textarea>
        </div>
        <div class="col">
            <label for="anhsp" class="form-label">Chọn file (nhiều file có thể chọn)</label>
            <div class="input-group">
                <input type="file" class="form-control" id="anhsp" name="anhsp[]" multiple>
            </div>
            <div id="anhsp_preview" class="image-preview"></div>
        </div>
        <br />
        <div class="col text-center">
            <button type="submit" class="btn btn-primary" onclick="return kiemTraCheckbox('Vui lòng chọn ít nhất 1 thương hiệu!');">Lưu thông tin</button>
        </div>
    </form>
</div>


<script>

    function kiemTraCheckbox(msg) {
        var checkboxes = document.querySelectorAll(".checkbox");
        var isChecked = false;

        checkboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                isChecked = true;
            }
        });

        if (!isChecked) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: 'warning',
                title: msg
            });
            return false;
        }
        return true;
    }


    // Lấy ra đối tượng input có id là 'anhsp'
    var anhsp = document.getElementById('anhsp');
    // Lấy ra đối tượng hiển thị ảnh preview có id là 'anhsp_preview'
    var anhsp_preview = document.getElementById('anhsp_preview');

    // Biến lưu trữ danh sách các file đã chọn
    let selectedFiles = [];

    // Hàm xóa ảnh preview
    function clearImagePreview() {
        anhsp_preview.innerHTML = '';
    }

    // Hàm hiển thị ảnh preview
    function displayImagePreview(files) {
        // Xóa nếu có ảnh preview cũ
        clearImagePreview();

        // Hiển thị modal quá trình tải lên
        $('#uploadProgressModal').modal('show');

        // Số lượng file được tải lên
        var totalFiles = files.length;
        let filesUploaded = 0;

        // Duyệt qua từng file và hiển thị ảnh preview
        files.forEach(function(file, index) {
            // Kiểm tra loại MIME của tệp tin
            if (file.type.startsWith('image/')) {
                // Tạo một container cho mỗi ảnh và nút xóa
                var imageContainer = document.createElement('div');
                imageContainer.className = 'image-item';

                // Tạo ảnh
                var img = document.createElement('img');

                // Sử dụng FileReader để đọc file và hiển thị
                var reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                };
                reader.readAsDataURL(file);

                img.alt = 'anhsp_preview';
                img.style.width = '200px';
                img.style.height = '200px';


                // Tạo một card Bootstrap cho mỗi ảnh và nút xóa
                var cardContainer = document.createElement('div');
                cardContainer.className = 'group-img card m-1';

                // Tạo một card-body để chứa ảnh và tên file
                var cardBody = document.createElement('div');
                cardBody.className = 'card-body';

                // Tạo ảnh
                var img = document.createElement('img');
                img.className = 'card-img-top';
                img.alt = 'anhsp_preview';
                img.src = URL.createObjectURL(file);
                img.style.width = '100%';

                // Tạo tên file
                var fileName = document.createElement('p');
                fileName.className = 'card-text';
                fileName.innerText = file.name;

                // Tạo nút xóa ảnh
                var deleteButton = document.createElement('button');
                deleteButton.className = 'btn btn-danger';
                deleteButton.innerText = 'Xóa ảnh';
                deleteButton.addEventListener('click', function() {
                    // Xóa card khi nút xóa được nhấp
                    cardContainer.remove();
                    // Cập nhật giá trị của input file với danh sách các file còn lại
                    updateFileInputValue(index);
                });

                // Thêm ảnh và tên file vào card-body
                cardBody.appendChild(img);
                cardBody.appendChild(fileName);

                // Thêm card-body và nút xóa vào card container
                cardContainer.appendChild(cardBody);
                cardContainer.appendChild(deleteButton);

                // Hiển thị card trong #anhsp_preview
                anhsp_preview.appendChild(cardContainer);



                // Tăng số lượng file đã tải lên
                filesUploaded++;

                // Cập nhật tiến trình trên modal
                var progress = (filesUploaded / totalFiles) * 100;
                $('.progress-bar').css('width', progress + '%').attr('aria-valuenow', progress);

                // Nếu tất cả file đã được tải lên, ẩn modal
                if (filesUploaded === totalFiles) {
                    $('#uploadProgressModal').modal('hide');
                }
            } else {
                // Nếu không phải là ảnh, thông báo lỗi
                alert('Vui lòng chọn một tệp tin hình ảnh.');
                // Đặt giá trị của input file về rỗng để xóa tệp đã chọn
                anhsp.value = '';
            }
        });
    }

    // Hàm cập nhật giá trị của input file với danh sách các file còn lại
    function updateFileInputValue(index) {
        // Xóa file đã chọn khỏi mảng
        selectedFiles.splice(index, 1);

        // Tạo một đối tượng DataTransfer để cập nhật giá trị của input file
        var dataTransfer = new DataTransfer();

        // Thêm các file còn lại vào đối tượng DataTransfer
        selectedFiles.forEach(file => {
            dataTransfer.items.add(file);
        });

        // Gán đối tượng DataTransfer cho input file
        anhsp.files = dataTransfer.files;

        // Gửi sự kiện change để kích hoạt lại sự kiện change
        anhsp.dispatchEvent(new Event('change'));
    }

    // Khi giá trị của input 'anhsp' thay đổi
    anhsp.addEventListener('change', function(evt) {
        // Lấy ra mảng các file được chọn trong input
        var files = Array.from(anhsp.files);

        // Lưu trữ các file vào biến selectedFiles
        selectedFiles = files;

        // Hiển thị ảnh preview cho tất cả các file được chọn
        displayImagePreview(files);
    });
    
</script>