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

class ThuongHieuModel extends Database
{

    public function ThuongHieu__Get_All($trangthai = null)
    {
        if ($trangthai == -1) {
            $obj = $this->connect->prepare("SELECT * FROM thuonghieu");
        } else {
            $obj = $this->connect->prepare("SELECT * FROM thuonghieu WHERE trangthai=1");
        }
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }
    public function ThuongHieu__Add($tenth, $mota, $trangthai)
    {
        $obj = $this->connect->prepare("INSERT INTO thuonghieu(tenth, mota, trangthai) VALUES (?,?,?)");
        $obj->execute(array($tenth, $mota));
        return $obj->rowCount();
    }

    public function ThuongHieu__Update($math, $tenth, $mota, $trangthai)
    {
        $obj = $this->connect->prepare("UPDATE thuonghieu SET tenth=?, mota=?, trangthai=? WHERE math=?");
        $obj->execute(array($tenth, $mota, $trangthai, $math));
        return $obj->rowCount();
    }
    public function ThuongHieu__Delete($math)
    {
        $obj = $this->connect->prepare("DELETE FROM thuonghieu WHERE math = ?");
        $obj->execute(array($math));
        return $obj->rowCount();
    }

    public function ThuongHieu__Get_By_Id($math)
    {
        $obj = $this->connect->prepare("SELECT * FROM thuonghieu WHERE math = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($math));
        return $obj->fetch();
    }
}
