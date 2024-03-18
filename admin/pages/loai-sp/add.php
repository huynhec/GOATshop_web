<div class="main-add">
    <h3 class="section-title">Thêm loại sản phẩm</h3>
    <form class="form-group" action="pages/loai-sp/action.php?req=add" method="post">
        <div class="col">
            <label for="tenloai" class="form-label">Tên loại</label>
            <input type="text" class="form-control" id="tenloai" name="tenloai" required>
        </div>
        <div class="row">
            <label for="mota" class="form-label">Thêm thuộc tính: </label>
            <div id="inputContainer">
                <div class="input-group mb-2">
                    <input type="text" name="thuoctinh[]" placeholder="Thuộc tính 1" class="form-control" required>
                    <!-- <button type="button" class="btn btn-danger" onclick="removeInput(this)">Xoá</button> -->
                </div>
            </div>
        </div>
        <div class="col text-center">
            <button type="button" class="btn btn-primary mt-2" onclick="addInput()">Thêm thuộc tính</button>
        </div>

        </div>
        <div class="col">
            <label for="trangthai" class="form-label">Trạng thái</label>
            <select class="form-select " aria-label=".trangthai" id="trangthai" name="trangthai">
                <option value="1" selected>Hiển thị</option>
                <option value="0">Tạm ẩn</option>
            </select>
        </div>
        <br />
        <div class="col text-center">
            <button type="submit" class="btn btn-primary">Lưu thông tin</button>
        </div>
    </form>
</div>