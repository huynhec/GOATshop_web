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

class SizeSpModel extends Database
{

    public function SizeSp__Get_All()
    {
        $obj = $this->connect->prepare("SELECT * FROM size_sp");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }

    public function SizeSp__Add($masp, $masize)
    {
        $obj = $this->connect->prepare("INSERT INTO size_sp (masp, masize) VALUES (?,?)");
        $obj->execute(array($masp, $masize));

        return $this->connect->lastInsertId();
    }

    public function SizeSp__Get_By_Id($masp)
    {
        $obj = $this->connect->prepare("SELECT size_sp.masp, size_sp.masize, size.tensize
        FROM size_sp
        JOIN size ON size_sp.masize = size.masize
        WHERE size_sp.masize = ?
        GROUP BY size_sp.masize 
        ORDER BY size_sp.id DESC");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($masp));
        return $obj->fetch();
    }
}
