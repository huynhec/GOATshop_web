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
    public function import__Add($masp, $masp_rec, $sup, $conf)
    {
        $obj = $this->connect->prepare("INSERT INTO goiy(masp, masp_rec, sup, conf) VALUES (?,?,?,?)");
        $obj->execute(array($masp, $masp_rec, $sup, $conf));
        return $obj->rowCount();
    }
}
