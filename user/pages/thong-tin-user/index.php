<?php
require_once '../model/KhachHangModel.php';
require_once '../model/DiaChiModel.php';

$kh = new KhachHangModel();
$dc = new DiaChiModel();
$makh = isset($_SESSION['user']->makh) ? $_SESSION['user']->makh : 0;
$dc__Get_By_Id_makh = $dc->DiaChi__Get_By_Id($makh);
$khachHang__Get_By_Id = $kh->KhachHang__Get_By_Id($makh);
?>




<section id="breadcrumb-wrapper" class="breadcrumb-w-img">
    <picture>
        <img src="../assets/images/Black logo - no background copy.png">

    </picture>
    <div class="breadcrumb-overlay"></div>

</section>
<div class="container">
    <h1>Tài khoản của bạn </h1>
    <!-- <a href="../auth/pages/action.php?req=dang-xuat"><i class="fa fa-sign-out"></i></a>               -->

    <div class="user-cards">
        <div class="user-card">
            <h2><?= $khachHang__Get_By_Id->tenkh; ?></h2>
            <p>Email: <?= $khachHang__Get_By_Id->email; ?></p>
            <p>Số điện thoại: <?= $khachHang__Get_By_Id->sodienthoai; ?></p>
            <p>Địa chỉ :<?= $dc->DiaChi__Get_By_Full_Ad($dc__Get_By_Id_makh->diachi_id)->full_dc; ?></p>
            <!-- <a href="../auth/pages/action.php?req=dang-xuat">Chỉnh sửa thông tin <i class="fas fa-cog"></i></a> -->
            <a href="../auth?pages=chinh-sua" class="edit-profile">
                Chỉnh sửa thông tin <i class="fas fa-cog"></i>
            </a>
            <!-- Nút đăng xuất -->
            <a href="../auth/pages/action.php?req=dang-xuat" class="logout-button">
                Đăng xuất <i class="fa fa-sign-out"></i>
            </a>
        </div>
    </div>

</div>
<style>
    .user-card {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .user-card h2 {
        font-size: 24px;
        margin-bottom: 10px;
    }

    .user-card p {
        margin-bottom: 5px;
    }

    .user-card a {
        /* color: #007bff; */
        text-decoration: none;
        display: inline-block;
        margin-top: 10px;
        transition: color 0.3s ease;
    }

    .user-card a:hover {
        color: #0056b3;
    }

    /*  */
    .container {
        max-width: 1060px;
        margin: 0 auto;
        padding: 0 15px;
    }

    @media (max-width: 768px) {
        .user-card {
            padding: 15px;
        }
    }

    .edit-profile {
        /* float: left; */
        margin-right: 10px;
        color: #007bff;
    }

    .logout-button {
        /* position: fixed; */
        float: right;
        margin-left: 10px;
        color: red;
    }
</style>