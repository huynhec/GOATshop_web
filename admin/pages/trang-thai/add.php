<div class="main-add">
    <h3 class="section-title">Thêm trạng thái</h3>
    <form class="form-group" action="pages/trang-thai/action.php?req=add" method="post">
        <div class="col">
            <label for="tentt" class="form-label">Tên trạng thái</label>
            <input type="text" class="form-control" id="tentt" name="tentt" required>
        </div>
        <div class="col">
            <label for="mota" class="form-label">Mô tả</label>
            <textarea class="form-control" id="mota" name="mota"></textarea>
        </div>
        <br />
        <div class="col text-center">
        <button type="submit" class="btn btn-primary">Lưu thông tin</button>
        </div>
    </form>
</div>