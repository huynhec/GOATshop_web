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

class NhanVienModel extends Database
{

    public function NhanVien__Get_All($trangthai = null)
    {
        if ($trangthai != -1) {
            $obj = $this->connect->prepare("SELECT * FROM nhanvien ");
        } else {
            $obj = $this->connect->prepare("SELECT * FROM nhanvien WHERE trangthai=1 ");
        }
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }


    public function NhanVien__Check_Email($email)
    {
        $obj = $this->connect->prepare("SELECT * FROM nhanvien WHERE email = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($email));
        if ($obj->rowCount() > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function NhanVien__Get_By_Id($manv)
    {
        $obj = $this->connect->prepare("SELECT * FROM nhanvien WHERE manv = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($manv));
        return $obj->fetch();
    }


    public function NhanVien__Dang_Nhap($emailOrUsername, $password)
    {
        // Kiểm tra xem đầu vào có phải là email hay username
        if (filter_var($emailOrUsername, FILTER_VALIDATE_EMAIL)) {
            $sql = "SELECT users.*, nhanvien.* FROM nhanvien INNER JOIN users ON nhanvien.mauser = users.mauser WHERE nhanvien.email = ? AND users.password = ?";
        } else {
            $sql = "SELECT users.*, nhanvien.* FROM users INNER JOIN nhanvien ON users.mauser = nhanvien.mauser WHERE users.username = ? AND users.password = ?";
        }

        $obj = $this->connect->prepare($sql);
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($emailOrUsername, $password));
        if ($obj->rowCount() > 0) {
            return $obj->fetch();
        } else {
            return 0;
        }
    }
}
