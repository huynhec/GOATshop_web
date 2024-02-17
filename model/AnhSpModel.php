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

class AnhSpModel extends Database
{

    public function AnhSp__Get_All()
    {
        $obj = $this->connect->prepare("SELECT * FROM anhsp");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }
    public function AnhSp__Add($hinhanh, $masp)
    {
        $obj = $this->connect->prepare("INSERT INTO anhsp(hinhanh, masp) VALUES (?,?)");
        $obj->execute(array($hinhanh, $masp));
        return $obj->rowCount();
    }

    public function AnhSp__Update($maanh, $hinhanh, $masp)
    {
        $obj = $this->connect->prepare("UPDATE anhsp SET hinhanh=?, masp=? WHERE maanh=?");
        $obj->execute(array($hinhanh, $masp, $maanh));
        return $obj->rowCount();
    }
    public function AnhSp__Delete($maanh)
    {
        $obj = $this->connect->prepare("DELETE FROM anhsp WHERE maanh = ?");
        $obj->execute(array($maanh));
        return $obj->rowCount();
    }

    public function AnhSp__Delete_By_Id_Sp($masp)
    {
        $obj = $this->connect->prepare("DELETE FROM anhsp WHERE masp = ?");
        $obj->execute(array($masp));
        return $obj->rowCount();
    }


    public function AnhSp__Get_By_Id($maanh)
    {
        $obj = $this->connect->prepare("SELECT * FROM anhsp WHERE maanh = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($maanh));
        return $obj->fetch();
    }

    public function AnhSp__Get_By_Id_Sp($masp)
    {
        $obj = $this->connect->prepare("SELECT * FROM anhsp WHERE masp = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($masp));
        return $obj->fetchAll();
    }

    public function AnhSp__Get_By_Id_Sp_First($masp)
    {
        $obj = $this->connect->prepare("SELECT * FROM anhsp WHERE masp = ? ORDER BY maanh ASC LIMIT 1");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($masp));
        return $obj->fetch();
    }
    public function AnhSp__Get_By_Id_Sp_Not_First($masp)
    {
        $maanh = $this->AnhSp__Get_By_Id_Sp_First($masp)->maanh;
        $obj = $this->connect->prepare("SELECT * FROM anhsp WHERE masp = ? AND maanh !=? ORDER BY maanh ASC");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($masp, $maanh));
        return $obj->fetchAll();
    }
}
