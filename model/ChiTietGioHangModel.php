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

class ChiTietGioHangModel extends Database
{

    public function ChiTietGioHang__Get_All()
    {
        $obj = $this->connect->prepare("SELECT * FROM chitietgiohang");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }

    public function ChiTietGioHang__Add($magh, $masp, $soluong, $dongia, $masize)
    {

        $obj = $this->connect->prepare("INSERT INTO chitietgiohang(magh, masp, soluong, dongia, masize) VALUES (?,?,?,?,?)");
        $obj->execute(array($magh, $masp, $soluong, $dongia, $masize));

        return $this->connect->lastInsertId();
    }


    public function ChiTietGioHang__Update($mactgh, $magh, $masp, $soluong, $dongia)
    {
        $obj = $this->connect->prepare("UPDATE chitietgiohang SET magh=?, masp=?, soluong=?, dongia=? WHERE mactgh =?");
        $obj->execute(array($magh, $masp, $soluong, $dongia, $mactgh));
        return $obj->rowCount();
    }


    public function ChiTietGioHang__Delete($mactgh)
    {
        $deleteStatement = $this->connect->prepare("DELETE FROM chitietgiohang WHERE mactgh=?");
        $deleteStatement->execute(array($mactgh));
        return $deleteStatement->rowCount();
    }

    public function ChiTietGioHang__Check($magh, $masp, $makh, $masize)
    {
        $obj = $this->connect->prepare("SELECT * FROM chitietgiohang INNER JOIN giohang ON chitietgiohang.magh = giohang.magh WHERE giohang.magh=? AND masp=? AND makh = ? AND masize =? AND trangthai=?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($magh, $masp, $makh, $masize, 1));
        if ($obj->rowCount() > 0) {
            return $obj->fetch();
        } else {
            return false;
        }
    }
    public function ChiTietGioHang__Get_By_Id($mactgh)
    {
        $obj = $this->connect->prepare("SELECT * FROM chitietgiohang WHERE mactgh=?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($mactgh));
        return $obj->fetch();
    }
    public function ChiTietGioHang__Sum_Tien_GH($magh)
    {
        $obj = $this->connect->prepare("SELECT SUM(soluong * dongia) as sum_tien FROM chitietgiohang WHERE magh=?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($magh));
        return $obj->fetch();
    }
    public function ChiTietGioHang__Get_By_Id_GH($magh)
    {
        $obj = $this->connect->prepare("SELECT *, (soluong*dongia) as tongcong FROM chitietgiohang WHERE magh=? ORDER BY mactgh DESC");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($magh));
        return $obj->fetchAll();
    }
}
