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

class ImportModel extends Database
{

    public function import__Get_All()
    {
        $obj = $this->connect->prepare("SELECT * FROM goiy");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }
    public function import_View__Get_All()
    {
        $obj = $this->connect->prepare("SELECT * FROM luotxem");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }
    public function import_Tracking__Get_All()
    {
        $obj = $this->connect->prepare("SELECT 
        kh.makh AS user, 
        sp.masp AS item, 
        tr.thoigian AS rating
        FROM khachhang kh
        CROSS JOIN sanpham sp
        LEFT JOIN user_item_tracking tr ON kh.makh = tr.makh AND sp.masp = tr.masp
        ORDER BY kh.makh, sp.masp;");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }
    public function import__Add($masp, $masp_rec, $sup, $conf)
    {
        $obj = $this->connect->prepare("INSERT INTO goiy(masp, masp_rec, sup, conf) VALUES (?,?,?,?)");
        $obj->execute(array($masp, $masp_rec, $sup, $conf));
        return $obj->rowCount();
    }
    public function import__Add_User_Based($user, $rank, $item)
    {
        $obj = $this->connect->prepare("UPDATE  goiy_user_based SET user =?, rank = ?, item = ?");
        $obj->execute(array($user, $rank, $item));
        return $obj->rowCount();
    }
}
