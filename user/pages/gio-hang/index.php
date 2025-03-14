<?php
$database = new Database();
$pdo = $database->connect;

// Chuẩn bị và thực thi truy vấn SQL để lấy dữ liệu từ bảng 'province'
try {
    $sql = "SELECT * FROM province";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Lỗi truy vấn: " . $e->getMessage();
    die();
}

require_once '../model/GioHangModel.php';
require_once '../model/ChiTietGioHangModel.php';
require_once '../model/SanPhamModel.php';
require_once '../model/AnhSpModel.php';
require_once '../model/CommonModel.php';
require_once '../model/SizeModel.php';
require_once '../model/DiaChiModel.php';
require_once '../model/DonHangModel.php';

$gh = new GioHangModel();
$ctgh = new ChiTietGioHangModel();
$sp = new SanPhamModel();
$anhSp = new AnhSpModel();
$cm = new CommonModel();
$sz = new SizeModel();
$dc = new DiaChiModel();
$dh = new DonHangModel();
$makh = isset($_SESSION['user']->makh) ? $_SESSION['user']->makh : 0;
$gioHang__Get_By_Id_Kh = $gh->GioHang__Get_By_Id_Kh($makh);
$chiTietGioHang__Get_By_Id_Gh = $ctgh->ChiTietGioHang__Get_By_Id_GH(isset($gioHang__Get_By_Id_Kh->magh) ? $gioHang__Get_By_Id_Kh->magh : 0);
$dc__Get_By_Id_makh = $dc->DiaChi__Get_By_Id($makh);
$donHang__Get_By_Id_Kh = $dh->DonHang__Get_By_Id_KH($makh);
?>
<style>
    /* CSS for payment method section */
    .section {
        margin-bottom: 20px;
    }

    .section-header {
        margin-bottom: 10px;
    }

    .section-title-method {
        font-size: 14px;
        font-weight: bold;
        display: block;
        background: #000000;
        color: #fff;
        text-align: center;
        outline: none;
        cursor: pointer;
        padding: 10px;
        margin: 0px;
    }

    .section-content {
        border: 1px solid #ccc;
        padding: 5px;
        border-radius: 5px;
    }

    .content-box {
        margin-bottom: 20px;
    }

    .content-box-row {
        margin-bottom: 10px;
        display: flex;
        align-items: center;
    }

    .input-radio {
        margin-right: 0px;
    }

    .main-img {
        width: 40px;
        height: 40px;
        margin-right: 10px;
    }

    .radio-label-primary {
        font-weight: bold;
    }

    .section .section-content .content-box .content-box-row:first-child {
        border-top-left-radius: 4px;
        border-top-right-radius: 4px;
        border-top: none;
    }

    .radio-wrapper .radio-label .radio-label-primary,
    .checkbox-wrapper .checkbox-label .checkbox-label-primary {
        display: table-cell;
        width: 100%;
    }

    .section .section-content .content-box .content-box-row {
        display: table;
        box-sizing: border-box;
        width: 100%;
        border-top: 1px solid #d9d9d9;
        zoom: 1;
    }

    .radio-wrapper .radio-label,
    .checkbox-wrapper .checkbox-label {
        display: flex !important;
        cursor: pointer !important;
        align-items: center;
        padding: 0.8em;
        width: auto;
    }

    .radio-wrapper .two-page,
    .checkbox-wrapper .checkbox-label {
        display: flex;
        cursor: pointer;
        align-items: center;
        padding: 1.3em;
        width: auto;
    }

    .radio-wrapper .payment-method-checkbox {
        display: flex;
        align-self: center;
    }

    .radio-wrapper .radio-input,
    .checkbox-wrapper .checkbox-input {
        display: table-cell;
        padding-right: 0.75em;
        white-space: nowrap;
    }

    .radio-wrapper .radio-content-input {
        display: flex;
        align-items: center;
    }

    .section .section-content .content-box .content-box-row.content-box-row-secondary {
        background-color: #fafafa;
    }
</style>
<script src="../assets/js/diachi.js"></script>
<main class="main">
    <div class="main-container">
        <section class="h-100 h-custom" style="background-color: #eee;">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col">
                        <div class="card">
                            <div class="card-body p-4">

                                <div class="row">
                                    <div class="col-lg-6">
                                        <h5 class="mb-3"><a href="?pages=trang-chu" class="text-body"><i class="bx bx-left-arrow-alt me-2"></i>Tiếp tục mua sắm</a></h5>
                                        <hr>

                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <div>
                                                <p class="mb-1">Giỏ hàng của bạn</p>
                                                <p class="mb-0">Bạn có <?= count($chiTietGioHang__Get_By_Id_Gh) ?> sản phẩm trong giỏ hàng</p>
                                            </div>
                                        </div>
                                        <?php $count = 0;
                                        foreach ($chiTietGioHang__Get_By_Id_Gh as $item) : ?>

                                            <div class="card mb-3">
                                                <div class="card-body p-1">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="d-flex flex-row align-items-center">
                                                            <div class="mw-100">
                                                                <img src="../assets/<?= $anhSp->AnhSp__Get_By_Id_Sp_First($item->masp)->hinhanh ?>" class="img-fluid rounded-3">
                                                            </div>
                                                            <div class="ms-2 me-2">
                                                                <div class="text-line"><?= $sp->SanPham__Get_By_Id($item->masp)->tensp ?></div>
                                                                <div class="text-line">
                                                                    Size : <?= $sz->Size__Get_By_Id($item->idsize)->tensize ?>
                                                                </div>
                                                                <p class="small mb-0 text-small" id="gh-dg_<?= $item->mactgh ?>"><?= number_format($item->dongia) ?>đ</p>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex flex-row align-items-center m-1">
                                                            <div class="input-group input-group-sm">
                                                                <button class="btn btn-sm btn-outline-secondary" onclick="decrease(this)" type="button">-</button>
                                                                <input type="text" class="form-control quantity" id="gh-sl" value="<?= $item->soluong ?>" readonly data-mactgh="<?= $item->mactgh ?>" , data-magh="<?= $item->magh ?>" , data-dongia="<?= $item->dongia ?>" , data-masp="<?= $item->masp ?>">
                                                                <button class="btn btn-sm btn-outline-secondary" onclick="increase(this)" type="button">+</button>
                                                                <!-- <h5 class="fw-normal mb-0">2</h5> -->
                                                            </div>
                                                            <div class="m-2">
                                                                <b class="mb-0" id="gh-tc_<?= $item->mactgh ?>"><?= number_format($item->tongcong) ?>đ</b>
                                                            </div>
                                                            <span onclick="remove(<?= $item->mactgh ?>)" style="color: #cecece;"><i class="bx bxs-trash-alt m-2"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach ?>

                                    </div>
                                    <?php if (isset($gioHang__Get_By_Id_Kh->magh) && count($chiTietGioHang__Get_By_Id_Gh) > 0) : ?>
                                        <div class="col-lg-6">

                                            <div class="card bg-outline rounded-3">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                                        <h5 class="mb-0">Thông tin nhận hàng</h5>
                                                    </div>

                                                    <form action="./components/action.php" method="post">

                                                        <div class="mt-4">
                                                            <div class="form-outline form-white mb-1">
                                                                <label class="form-label" for="tenkh">Tên người nhận</label>
                                                                <input type="text" name="tenkh" id="tenkh" class="form-control" siez="17" placeholder="Tên người nhận" value="<?= $_SESSION['user']->tenkh ?>" minlength="8" maxlength="50" required />

                                                            </div>
                                                            <!-- địa chỉ -->
                                                            <div class="form-group">
                                                                <label for="tinh">Tỉnh/Thành phố</label>
                                                                <select id="tinh" name="tinh" class="form-control" onchange="clear_road();">
                                                                    <?php
                                                                    $province_cur = $dc->DiaChi__Get_By_Id_Kh($makh, 'province');
                                                                    ?>
                                                                    <?php if (isset($province_cur->province_id)) : ?>
                                                                        <option value="<?php echo $province_cur->province_id ?>" selected><?php echo $province_cur->name ?></option>
                                                                    <?php else : ?>
                                                                        <option value="">Chọn một tỉnh/thành phố</option>

                                                                    <?php endif ?>

                                                                    <?php foreach ($results as $row) : ?>
                                                                        <?php if ($row['province_id'] != $province_cur->province_id) : ?>
                                                                            <option value="<?php echo $row['province_id'] ?>"><?php echo $row['name'] ?></option>
                                                                        <?php endif ?>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                                <!-- Thêm hidden input để lưu tên tỉnh -->
                                                                <input type="hidden" id="tinh_name" name="tinh_name" value="<?php echo $row['name'] ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="huyen">Quận/Huyện</label>
                                                                <select id="huyen" name="huyen" class="form-control">
                                                                    <?php
                                                                    $district_cur = $dc->DiaChi__Get_By_Id_Kh($makh, 'district');
                                                                    ?>

                                                                    <?php if (isset($district_cur->district_id)) : ?>
                                                                        <option value="<?php echo $district_cur->district_id ?>" selected><?php echo $district_cur->name ?></option>
                                                                    <?php else : ?>
                                                                        <option value="">Chọn một quận/huyện</option>
                                                                    <?php endif ?>
                                                                </select>

                                                                <!-- Thêm hidden input để lưu tên huyện -->
                                                                <input type="hidden" id="huyen_name" name="huyen_name" value="">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="xa">Phường/Xã</label>
                                                                <select id="xa" name="xa" class="form-control">
                                                                    <?php
                                                                    $wards_cur = $dc->DiaChi__Get_By_Id_Kh($makh, 'wards');
                                                                    ?>
                                                                    <?php if (isset($wards_cur->wards_id)) : ?>
                                                                        <option value="<?php echo $wards_cur->wards_id ?>" selected><?php echo $wards_cur->name ?></option>
                                                                    <?php else : ?>
                                                                        <option value="">Chọn một xã</option>

                                                                    <?php endif ?>
                                                                </select>
                                                                <!-- Thêm hidden input để lưu tên xã -->
                                                                <input type="hidden" id="xa_name" name="xa_name" value="">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="road">Số nhà</label>
                                                                <?php
                                                                $road_cur = $dc->Road__Get_By_Id_Kh($makh);
                                                                ?>


                                                                <input id="road" name="road" class="form-control" value="<?= isset($road_cur->road) ? $road_cur->road : '' ?>">
                                                            </div>

                                                            <div class="row mb-4">
                                                                <div class="col-md-6">
                                                                    <div class="form-outline form-white">
                                                                        <label class="form-label" for="sodienthoai">Số điện thoại</label>
                                                                        <input type="tel" pattern="[0-9]{10}" minlength="10" maxlength="10" class="form-control" id="sodienthoai" name="sodienthoai" value="<?= $_SESSION['user']->sodienthoai ?>" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-outline form-white">
                                                                        <label class="form-label" for="email">Email</label>
                                                                        <input type="email" class="form-control" id="email" name="email" value="<?= $_SESSION['user']->email ?>" readonly required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr class="my-4">
                                                        <div id="section-payment-method" class="section">
                                                            <div class="order-checkout__loading--box">
                                                                <div class="order-checkout__loading--circle"></div>
                                                            </div>
                                                            <div class="step-sections " step="2">
                                                                <div id="section-shipping-rate" class="section">
                                                                    <div class="order-checkout__loading--box">
                                                                        <div class="order-checkout__loading--circle"></div>
                                                                    </div>
                                                                    <div class="section-header">
                                                                        <h2 class="section-title-method">Phương thức vận chuyển</h2>
                                                                    </div>
                                                                    <div class="section-content">
                                                                        <div class="content-box">
                                                                            <div class="content-box-row">
                                                                                <div class="radio-wrapper">
                                                                                    <label class="radio-label" for="shipping_rate_id_1000166705">
                                                                                        <div class="radio-input">
                                                                                            <input id="shipping_rate_id" class="input-radio" type="radio" name="shipping_rate_id" value="30000" checked>
                                                                                        </div>
                                                                                        <span class="radio-label-primary">Giao hàng tận nơi</span>
                                                                                        <span class="radio-accessory content-box-emphasis">
                                                                                            30,000₫
                                                                                        </span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div id="section-payment-method" class="section">
                                                                    <div class="order-checkout__loading--box">
                                                                        <div class="order-checkout__loading--circle"></div>
                                                                    </div>
                                                                    <div class="section-header">
                                                                        <h2 class="section-title-method">Phương thức thanh toán</h2>
                                                                    </div>
                                                                    <div class="section-content">
                                                                        <div class="content-box">
                                                                            <div class="radio-wrapper content-box-row">
                                                                                <label class="two-page" for="payment_method_id_1002112112">
                                                                                    <div class="radio-input payment-method-checkbox">
                                                                                        <input type-id="1" id="payment_method_id" class="input-radio" name="payment_method_id" type="radio" value="cod" checked>
                                                                                    </div>

                                                                                    <div class="radio-content-input">
                                                                                        <img class="main-img" src="https://hstatic.net/0/0/global/design/seller/image/payment/cod.svg?v=6">
                                                                                        <div class="content-wrapper">
                                                                                            <span class="radio-label-primary">Thanh toán khi giao hàng (COD)</span>
                                                                                            <span class="quick-tagline hidden"></span>
                                                                                        </div>
                                                                                    </div>
                                                                                </label>
                                                                            </div>

                                                                            <div class="radio-wrapper content-box-row" id="radio-wrapper">
                                                                                <label class="two-page" for="payment_method_id_1002112115">
                                                                                    <div class="radio-input payment-method-checkbox">
                                                                                        <input type-id="2" id="payment_method_id" class="input-radio" name="payment_method_id" type="radio" value="bank_transfer">
                                                                                    </div>

                                                                                    <div class="radio-content-input">
                                                                                        <img class="main-img" src="https://hstatic.net/0/0/global/design/seller/image/payment/other.svg?v=6">
                                                                                        <div class="content-wrapper">
                                                                                            <span class="radio-label-primary">Chuyển khoản qua ngân hàng</span>
                                                                                            <span class="quick-tagline hidden"></span>
                                                                                        </div>
                                                                                    </div>
                                                                                </label>
                                                                            </div>
                                                                            <hr>
                                                                            <div class="d-flex justify-content-between">
                                                                                <p class="mb-2" style="font-weight: bolder;">Tổng hóa đơn: </p>
                                                                                <?php $total = $ctgh->ChiTietGioHang__Sum_Tien_GH($item->magh)->sum_tien + 30000 ?>
                                                                                <b class="mb-2 text-danger" id="gh-sum"><?= number_format($total) ?>đ</b>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>

                                                        <hr class="my-2">
                                                        <button type="button" onclick="return checkout()" class="btn btn-lg btn-outline-dark w-100 fw-bold" style="border-width: 2px;">
                                                            <input type="hidden" id="magh" name="magh" value="<?= $gioHang__Get_By_Id_Kh->magh ?>" readonly>
                                                            <input type="hidden" id="makh" name="makh" value="<?= $_SESSION['user']->makh ?>" readonly>
                                                            <input type="hidden" id="username" name="username" value="<?= $_SESSION['user']->username ?>" readonly>
                                                            <input type="hidden" id="password" name="password" value="<?= $_SESSION['user']->password ?>" readonly>
                                                            <input type="hidden" id="action" name="action" value="checkout">
                                                            <span>Hoàn tất đơn hàng </span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>

                                        </div>
                                    <?php endif ?>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<script>
    // function toggleBankDetails() {
    //     var bankDetails = document.getElementById("blank-slate");
    //     var paymentMethods = document.getElementsByName("payment_method_id");
    //     for (var i = 0; i < paymentMethods.length; i++) {
    //         if (paymentMethods[i].value === "bank_transfer" && paymentMethods[i].checked) {
    //             bankDetails.style.display = "block";
    //         } else if (paymentMethods[i].checked) {
    //             bankDetails.style.display = "none";
    //         }
    //     }
    // }

    document.addEventListener("DOMContentLoaded", function() {
        var radioWrappers = document.querySelectorAll('.radio-wrapper');

        radioWrappers.forEach(function(wrapper) {
            wrapper.addEventListener('click', function() {
                // Tìm input radio trong wrapper
                var radioInput = wrapper.querySelector('.input-radio');

                // Nếu input radio được tìm thấy và chưa được chọn, thay đổi trạng thái
                if (radioInput && !radioInput.checked) {
                    radioInput.checked = true;
                }
            });
        });
    });

    function clear_road() {
        document.getElementById("road").value = '';
    }

    function remove(mactgh) {
        Swal.fire({
            icon: 'question',
            title: "Xác nhận",
            text: "Bạn chắc chắn xóa sản phẩm này khỏi giỏ hàng?",
            showCancelButton: true,
            confirmButtonText: "OK",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "./components/action.php",
                    data: {
                        action: "remove",
                        mactgh: mactgh
                    },
                    success: function(response) {
                        console.log(response);
                        if (response == true) {
                            Swal.fire({
                                icon: "success",
                                title: "Sản phẩm đã xóa khỏi giỏ hàng thành công!",
                                confirmButtonText: "OK",
                            }).then((result) => {});
                            location.href = "?pages=gio-hang";
                        }
                    },
                });
            }
        });
    }

    function checkout() {
        var tenkh = document.getElementById('tenkh').value;
        var tinh = document.getElementById('tinh').options[document.getElementById('tinh').selectedIndex].text;
        var huyen = document.getElementById('huyen').options[document.getElementById('huyen').selectedIndex].text;
        var xa = document.getElementById('xa').options[document.getElementById('xa').selectedIndex].text;
        var road = document.getElementById('road').value;
        var sodienthoai = document.getElementById('sodienthoai').value;
        var email = document.getElementById('email').value;

        // Kiểm tra xem các trường đã được điền đầy đủ hay không
        if (tenkh.trim() === '' || tinh.trim() === '' || huyen.trim() === '' || xa.trim() === '' || road.trim() === '' || sodienthoai.trim() === '' || email.trim() === '') {
            // Nếu có trường nào chưa được điền đầy đủ, hiển thị thông báo lỗi
            alert('Vui lòng điền đầy đủ thông tin.');
            return false;
        }

        $.ajax({
            type: "POST",
            url: "./components/action.php",
            data: {
                action: "checkout",
                makh: document.getElementById('makh').value,
                tenkh: document.getElementById('tenkh').value,
                diachi: `${tinh}, ${huyen}, ${xa}, ${road}`,
                sodienthoai: document.getElementById('sodienthoai').value,
                email: document.getElementById('email').value,
                magh: document.getElementById('magh').value,
                username: document.getElementById('username').value,
                password: document.getElementById('username').value,
                payment_method: $("input[name='payment_method_id']:checked").val(),
                shipping_method: $("input[name='shipping_rate_id']:checked").val()
            },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.success) {
                    if (data.payment_method === 'bank_transfer') {
                        // window.location.href = './pages/gio-hang/viet_qr.php?madon=' + data.madon;
                        window.location.href = './pages/gio-hang/viet_qr.php?madon=' + data.madon + '&total_amount=' + data.total_amount;
                    } else {
                        Swal.fire({
                            icon: "success",
                            title: "Bạn đã đặt hàng thành công!",
                            confirmButtonText: "OK",
                        }).then(() => {
                            location.href = '?pages=trang-chu';
                        });
                    }
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Đặt hàng thất bại!",
                        text: data.message,
                        confirmButtonText: "OK"
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("Error: " + status + " " + error);
                console.error(xhr.responseText);
            }
            // success: function(response) {
            //     console.log(response); // Xác minh phản hồi từ server
            //     if (response == true) {
            //         Swal.fire({
            //             icon: "success",
            //             title: "Bạn đã đặt hàng thành công!",
            //             confirmButtonText: "OK",
            //         }).then((result) => {
            //             location.href = '?pages=trang-chu';
            //         });
            //     } else {
            //         Swal.fire({
            //             icon: "error",
            //             title: "Đặt hàng thất bại!",
            //             text: response, // Hiển thị lỗi từ server nếu có
            //             confirmButtonText: "OK"
            //         });
            //     }
            // },
            // error: function(xhr, status, error) {
            //     console.error("Error: " + status + " " + error); // Kiểm tra lỗi từ server
            //     console.error(xhr.responseText); // Xem phản hồi lỗi chi tiết từ server
            // }
        });

    }

    function decrease(button) {
        var input = button.nextElementSibling;
        var value = parseInt(input.value);
        if (value > 1) {
            input.value = value - 1;
        }
        $.ajax({
            type: "POST",
            url: "./components/action.php",
            data: {
                action: "update",
                mactgh: input.getAttribute('data-mactgh'),
                magh: input.getAttribute('data-magh'),
                masp: input.getAttribute('data-masp'),
                soluong: input.value,
                dongia: input.getAttribute('data-dongia'),
            },
            success: function(response) {
                var gh = JSON.parse(response);
                // Update quantity
                $("#gh-sl_" + input.getAttribute('data-mactgh')).text(gh.soluong);
                // Update total
                $("#gh-tc_" + input.getAttribute('data-mactgh')).text(gh.tongcong);
                // Update sum
                $("#gh-sum").text(gh.sum);
            },
        });
        return false; // Prevent default action of the button
    }



    function increase(button) {
        var input = button.previousElementSibling;
        var value = parseInt(input.value);
        if (value < 50) {
            input.value = value + 1;
        }
        $.ajax({
            type: "POST",
            url: "./components/action.php",
            data: {
                action: "update",
                mactgh: input.getAttribute('data-mactgh'),
                magh: input.getAttribute('data-magh'),
                masp: input.getAttribute('data-masp'),
                soluong: input.value,
                dongia: input.getAttribute('data-dongia'),
            },
            success: function(response) {
                var gh = JSON.parse(response);
                console.log(response);
                // Update quantity
                $("#gh-sl_" + input.getAttribute('data-mactgh')).text(gh.soluong);
                // Update total
                $("#gh-tc_" + input.getAttribute('data-mactgh')).text(gh.tongcong);
                // Update sum
                $("#gh-sum").text(gh.sum);
            },
        });


        return false; // Prevent default action of the button
    }
</script>