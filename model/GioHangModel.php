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

class GioHangModel extends Database
{

    public function GioHang__Get_All()
    {
        $obj = $this->connect->prepare("SELECT * FROM giohang");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }
    public function GioHang__Add($ngaythem, $makh, $trangthai)
    {
        $obj = $this->connect->prepare("INSERT INTO giohang(ngaythem, makh, trangthai) VALUES (?,?,?)");
        $obj->execute(array($ngaythem, $makh, $trangthai));
        return $this->connect->lastInsertId();
    }

    public function GioHang__Update($magh, $ngaythem, $makh, $trangthai)
    {
        $obj = $this->connect->prepare("UPDATE giohang SET ngaythem=?, makh=?, trangthai=? WHERE magh=?");
        $obj->execute(array($ngaythem, $makh, $trangthai, $magh));
        return $obj->rowCount();
    }

    public function GioHang__Update_Trang_Thai($magh, $trangthai)
    {
        $obj = $this->connect->prepare("UPDATE giohang SET trangthai=? WHERE magh=?");
        $obj->execute(array($trangthai, $magh));
        return $obj->rowCount();
    }

    public function GioHang__Delete($magh)
    {
        $obj = $this->connect->prepare("DELETE FROM giohang WHERE magh = ?");
        $obj->execute(array($magh));
        return $obj->rowCount();
    }

    public function GioHang__Get_By_Id($magh)
    {
        $obj = $this->connect->prepare("SELECT * FROM giohang WHERE magh = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($magh));
        return $obj->fetch();
    }
    public function GioHang__Get_By_Id_Kh($makh)
    {
        $obj = $this->connect->prepare("SELECT * FROM giohang WHERE makh = ? AND trangthai =1 ORDER BY magh DESC LIMIT 1");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($makh));
        return $obj->fetch();
    }
}
