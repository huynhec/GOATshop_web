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
    <h3 class="section-title">Thêm size</h3>
    <form class="form-group" action="pages/size/action.php?req=add" method="post">
        <div class="col">
            <label>Chọn loại sản phẩm:</label>
            <br>
            <?php foreach ($loaisp__Get_All as $item) : ?>
            <div class="form-check form-check-inline">
                <input class="btn-check" type="radio" id="ma_loai<?= $item->maloai ?>" value="<?= $item->maloai ?>"
                    name="maloai" required>
                <label class="btn btn-outline-primary" for="ma_loai<?= $item->maloai ?>"><?= $item->tenloai ?></label>
            </div>

            <?php endforeach; ?>
        </div>
        <div class="row">
            <div class="col-5 sizeten">
                <label for="mota" class="form-label">Tên size: </label>
                <div class="inputContainer1">
                    <div class="input-group mb-2">
                        <input type="text" name="tensize[]" placeholder="Tên size 1" class="form-control" required>
                    </div>
                </div>
            </div>

            <div class="col-3 sizetrangthai">
                <label for="trangthai" class="form-label">Trạng thái:</label>
                <select class="form-select" aria-label=".trangthai" id="trangthai" name="trangthai[]" required>
                    <option value="1" selected>Hiển thị</option>
                    <option value="0">Tạm ẩn</option>
                </select>
            </div>


        </div>
        <div class="row">
            <div class="col text-center">
                <button type="button" class="btn btn-primary mt-2" onclick="addInput2()">Thêm size</button>
            </div>
        </div>
        <br />
        <br />
        <div class="col text-center">
            <button type="submit" class="btn btn-primary">LƯU THÔNG TIN</button>
        </div>
    </form>
</div>