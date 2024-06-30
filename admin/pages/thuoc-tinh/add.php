<?php
require_once '../model/LoaiSpModel.php';

$loaisp = new LoaiSpModel();

$loaisp__Get_All = $loaisp->LoaiSp__Get_All();

?>

<!-- CSS Bootstrap -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<!-- JS Bootstrap (nếu bạn cần sử dụng các tính năng JavaScript của Bootstrap) -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<div class="main-add">
    <h3 class="section-title">Thêm thuộc tính</h3>
    <form class="form-group" action="pages/thuoc-tinh/action.php?req=add" method="post">
        <div class="col">
            <label>Chọn loại sản phẩm:</label>
            <br>
            <?php foreach ($loaisp__Get_All as $item) : ?>
                <div class="form-check form-check-inline">
                    <input class="btn-check" type="radio" id="ma_loai<?= $item->maloai ?>" value="<?= $item->maloai ?>" name="maloai" required>
                    <label class="btn btn-outline-primary" for="ma_loai<?= $item->maloai ?>"><?= $item->tenloai ?></label>
                </div>

            <?php endforeach; ?>
        </div>
        <div class="row">
            <div class="col-5">
                <label for="mota" class="form-label">Tên thuộc tính: </label>
                <div id="inputContainer">
                    <div class="input-group mb-2">
                        <input type="text" name="thuoctinh[]" placeholder="Thuộc tính 1" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <label for="trangthai" class="form-label">Trạng thái:</label>
                <select class="form-select" aria-label=".trangthai" id="trangthai" name="trangthai[]" required>
                    <option value="1" selected>Hiển thị</option>
                    <option value="0">Tạm ẩn</option>
                </select>
            </div>
            <div class="col-3">
                <label for="trangthai" class="form-label">Kiểu dữ liệu:</label>
                <br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input checkbox" type="radio" id="is_num_0" value="0" name="is_num[]" required checked>
                    <label class="form-check-label" for="is_num_0">Kiểu chữ</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input checkbox" type="radio" id="is_num_1" value="1" name="is_num[]" required>
                    <label class="form-check-label" for="is_num_1">Kiểu số</label>
                </div>
            </div>

        </div>
        <!-- <div class="row">
            <div class="col text-center">
                <button type="button" class="btn btn-primary mt-2" onclick="addInput()">Thêm thuộc
                    tính</button>
            </div>
        </div> -->
        <br />
        <br />
        <div class="col text-center">
            <button type="submit" class="btn btn-primary">LƯU THÔNG TIN</button>
        </div>
    </form>
</div>