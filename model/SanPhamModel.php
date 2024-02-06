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

class SanPhamModel extends Database
{

    public function SanPham__Get_All($trangthai)
    {
        if ($trangthai != -1) {
            $obj = $this->connect->prepare("SELECT * FROM sanpham");
        } else {
            $obj = $this->connect->prepare("SELECT * FROM sanpham WHERE trangthai = 1");
        }
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }

    public function SanPham__Get_By_Id($masp)
    {
        $obj = $this->connect->prepare("SELECT * FROM sanpham WHERE masp = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($masp));
        return $obj->fetch();
    }


    public function SanPham__Get_Top_Updated($limit = 6)
    {
        $sql = "SELECT * FROM sanpham
        WHERE trangthai=?
        GROUP BY sanpham.masp
        ORDER BY ngaythem DESC
        LIMIT $limit";

        $obj = $this->connect->prepare($sql);
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array(1));
        return $obj->fetchAll();
    }





}
