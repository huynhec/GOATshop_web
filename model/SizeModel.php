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

class SizeModel extends Database
{

    public function Size__Get_All()
    {
        $obj = $this->connect->prepare("SELECT * FROM size");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }

    public function Size__Add($size)
    {
        $obj = $this->connect->prepare("INSERT INTO size(tensize) VALUES (?)");
        $obj->execute(array($size));

        return $this->connect->lastInsertId();
    }

    public function Size__Get_By_Id($masize)
    {
        $obj = $this->connect->prepare("SELECT * FROM size WHERE masize = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($masize));
        return $obj->fetch();
    }
}
