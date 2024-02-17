<?php
require_once '../model/SanPhamModel.php';
$sp = new SanPhamModel();
$masp = $_GET['masp'];
$sanPham__Get_By_Id = $sp->SanPham__Get_By_Id($masp);
?>
<div class="main-add">
    <h3 class="section-title">Thêm hình ảnh</h3>
    <form id="chapterForm" class="form-group" action="pages/san-pham/action.php?req=c_add" method="post" enctype="multipart/form-data">
        <input type="hidden" class="form-control" id="masp" name="masp" required value="<?= $masp ?>" readonly>
        <div class="col">
            <label for="tensp" class="form-label">Tên sản phẩm</label>
            <input type="text" class="form-control" id="tensp" name="tensp" required value="<?= $sanPham__Get_By_Id->tensp ?>" readonly>
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