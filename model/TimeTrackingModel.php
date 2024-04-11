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

class TimeTrackingModel extends Database
{

    public function User_item_tracking__Get_All()
    {
        $obj = $this->connect->prepare("SELECT * FROM user_item_tracking");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }
    public function User_item_tracking__Add($timeCounter, $masp, $typetrack, $ngay)
    {
        $obj = $this->connect->prepare("INSERT INTO user_item_tracking(thoigian, masp, typetrack, ngay) VALUES (?,?,?,?)");
        $obj->execute(array($timeCounter, $masp, $typetrack, $ngay));
        
        return $obj->rowCount();
    }
    

    public function User_item_tracking__Update($maanh, $hinhanh, $masp)
    {
        $obj = $this->connect->prepare("UPDATE user_item_tracking SET hinhanh=?, masp=? WHERE maanh=?");
        $obj->execute(array($hinhanh, $masp, $maanh));
        return $obj->rowCount();
    }
    public function User_item_tracking__Delete($maanh)
    {
        $obj = $this->connect->prepare("DELETE FROM user_item_tracking WHERE maanh = ?");
        $obj->execute(array($maanh));
        return $obj->rowCount();
    }

    public function User_item_tracking__Delete_By_Id_Sp($masp)
    {
        $obj = $this->connect->prepare("DELETE FROM user_item_tracking WHERE masp = ?");
        $obj->execute(array($masp));
        return $obj->rowCount();
    }


    public function User_item_tracking__Get_By_Id($maanh)
    {
        $obj = $this->connect->prepare("SELECT * FROM user_item_tracking WHERE maanh = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($maanh));
        return $obj->fetch();
    }

    public function User_item_tracking__Get_By_Id_Sp($masp)
    {
        $obj = $this->connect->prepare("SELECT * FROM user_item_tracking WHERE masp = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($masp));
        return $obj->fetchAll();
    }

}
