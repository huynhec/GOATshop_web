<?php

$a = "./config/connect.php";
$b = "../config/connect.php";
$c = "../../config/connect.php";
$d = "../../../config/connect.php";
$e = "../../../../config/connect.php";
$f = "../../../../../config/connect.php";

if (file_exists($a)) {
    $des = $a;
}
if (file_exists($b)) {
    $des = $b;
}
if (file_exists($c)) {
    $des = $c;
}
if (file_exists($d)) {
    $des = $d;
}

if (file_exists($e)) {
    $des = $e;
}

if (file_exists($f)) {
    $des = $f;
}
include_once($des);

class KhachHangModel extends Database
{

    public function KhachHang__Get_All($trangthai = null)
    {
        if ($trangthai != -1) {
            $obj = $this->connect->prepare("SELECT * FROM khachhang");
        } else {
            $obj = $this->connect->prepare("SELECT * FROM khachhang WHERE trangthai =1");
        }
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }
    public function KhachHang__Add($tenhienthi, $gioitinh, $ngaysinh, $sodienthoai, $diachi, $email, $username, $password, $trangthai)
    {
        // Thêm người dùng vào bảng users
        $obj = $this->connect->prepare("INSERT INTO users (tenhienthi, username, password, phanquyen, trangthai)
                                        VALUES (?, ?, ?, 3 , ?)");
        $obj->execute(array($tenhienthi, $username, $password, $trangthai));

        // Lấy mauser vừa được thêm
        $mauser = $this->connect->lastInsertId();

        $obj = $this->connect->prepare("INSERT INTO khachhang(tenkh, gioitinh, ngaysinh, sodienthoai, diachi, email, trangthai, mauser) VALUES (?,?,?,?,?,?,?,?)");
        $obj->execute(array($tenhienthi, $gioitinh, $ngaysinh, $sodienthoai, $diachi, $email, $trangthai, $mauser));
        return $obj->rowCount();
    }

    public function KhachHang__Check_Email($email)
    {
        $obj = $this->connect->prepare("SELECT * FROM khachhang WHERE email = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($email));
        if ($obj->rowCount() > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function KhachHang__Dang_Nhap($emailOrUsername, $password)
    {
    // Kiểm tra xem đầu vào có phải là email hay username
    if (filter_var($emailOrUsername, FILTER_VALIDATE_EMAIL)) {
        $sql = "SELECT * FROM khachhang INNER JOIN users ON khachhang.mauser = users.mauser WHERE khachhang.email = ? AND users.password = ?";
    } else {
        $sql = "SELECT * FROM users INNER JOIN khachhang ON users.mauser = khachhang.mauser WHERE users.username = ? AND users.password = ?";
    }

        $obj = $this->connect->prepare($sql);
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($emailOrUsername, $password));

        if ($obj->rowCount() > 0) {
            return $obj->fetch();
        } else {
            return false;
        }
    }
}
