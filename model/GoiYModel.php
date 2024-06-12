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

class GoiYModel extends Database
{
    public function Goi_Y_User_Based($makh)
    {
        $obj = $this->connect->prepare("SELECT *
        FROM goiy_user_based
        INNER JOIN sanpham ON goiy_user_based.item = sanpham.masp
        WHERE goiy_user_based.user = ?
        ORDER BY goiy_user_based.rank ASC
        LIMIT 6;");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($makh));
        return $obj->fetchAll();
    }
}