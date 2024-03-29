<?php
require_once '../model/DonGiaModel.php';
require_once '../model/SanPhamModel.php';
$dongia = new DonGiaModel();
$sp = new SanPhamModel();
$masp = $_GET['masp'];
$sanPham__Get_By_Id = $sp->SanPham__Get_By_Id($masp);
$dongia__Get_By_Id_Sp = $dongia->DonGia__Get_By_Id_Sp($masp);
$dongia__Get_By_Id_Sp_First = $dongia->ShowDonGia__Get_By_Id_Spdg($masp);
// $dongia__Get_By_Id_Sp_Not_First = $dongia->ShowDonGia__Get_By_Id_Not_Spdg($masp);
?>

<div id="main-container">
    <div class="main-title">
        <h3>Quản lý sản phẩm nội dung</h3>
        <ul class="breadcrumb">
            <li>
                <a href="#">Quản lý sản phẩm</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active" href="index.php?pages=san-pham">Danh sách sản phẩm</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active" href="index.php?pages=anh-san-pham&masp=<?= $masp ?>">Danh sách
                    đơn giá</a>
            </li>
        </ul>
    </div>
    <div class="row section-container">
        <div class="col-7">
            <div class="main-data">
                <h3 class="section-title">Danh sách đơn giá sản phẩm: <b><?= $sanPham__Get_By_Id->tensp ?></b></h3>
                <div class="table-responsive">
                    <table id="table_js" class="table table-striped" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Đơn giá</th>
                                <th>Ngày nhập</th>
                                <th>Áp dụng</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($dongia__Get_By_Id_Sp as $item) : ?>
                            <tr>
                                <td><?= $item->id_dongia ?></td>
                                <td><?= $item->dongia ?></td>
                                <td><?= $item->ngaynhap ?></td>
                                <td><?= $item->apdung ?></td>
                                <td>
                                    <?php if ($item->apdung == 1) : ?>
                                    <!-- Nút sẽ hiển thị khi apdung == 1 -->
                                    <label class="switch"
                                        onclick="return update_apdung('<?= $item->id_dongia ?>', '<?= $item->apdung ?>')">
                                        <input type="checkbox" checked>
                                        <span class="slider"></span>
                                    </label>
                                    <?php else : ?>
                                    <!-- Nút sẽ ẩn khi apdung != 1 -->
                                    <label class="switch"
                                        onclick="return update_apdung('<?= $item->id_dongia ?>', '<?= $item->masp ?>')">
                                        <input type="checkbox">
                                        <span class="slider"></span>
                                    </label>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="col-5">
            <div class="main-form">
                <?php require_once 'gia_add.php' ?>
            </div>
            <br>
            <br>
            <div class="main-chart">
                <?php require_once 'gia_chart.php' ?>
            </div>
        </div>
    </div>
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


window.addEventListener('load', function() {
    document.getElementById('dynamicTitle').innerText = "";
})
</script>

<style>
.switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
}

.slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
}

input:checked+.slider {
    background-color: #2196F3;
}

input:focus+.slider {
    box-shadow: 0 0 1px #2196F3;
}

input:checked+.slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
    border-radius: 34px;
}

.slider.round:before {
    border-radius: 50%;
}
</style>