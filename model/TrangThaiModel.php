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

class TrangThaiModel extends Database
{

    public function TrangThai__Get_All()
    {
        $obj = $this->connect->prepare("SELECT * FROM trangthai");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }
  
    public function TrangThai__Add($tentt, $mota)
    {
        $obj = $this->connect->prepare("INSERT INTO trangthai(tentt, mota) VALUES (?,?)");
        $obj->execute(array($tentt, $mota));
        return $obj->rowCount();
    }

    public function TrangThai__Update($matt, $tentt, $mota)
    {
        $obj = $this->connect->prepare("UPDATE trangthai SET tentt=?, mota=? WHERE matt=?");
        $obj->execute(array($tentt, $mota, $matt));
        return $obj->rowCount();
    }

    public function TrangThai__Delete($matt)
    {
        $obj = $this->connect->prepare("DELETE FROM trangthai WHERE matt = ?");
        $obj->execute(array($matt));
        return $obj->rowCount();
    }

    public function TrangThai__Get_By_Id($matt)
    {
        $obj = $this->connect->prepare("SELECT * FROM trangthai WHERE matt = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($matt));
        return $obj->fetch();
    }

    public function TrangThai__Get_By_Id_DH($madon)
    {
        $obj = $this->connect->prepare("SELECT * FROM trangthai WHERE matt NOT IN (SELECT matt FROM chitiettrangthai WHERE madon = ?)");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($madon));
        return $obj->fetchAll();
    }
}