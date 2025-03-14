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

class DonHangModel extends Database
{

    public function DonHang__Get_All()
    {
        $obj = $this->connect->prepare("SELECT * FROM donhang ORDER BY madon DESC");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }
    public function DonHang__Add($ngaythem, $makh, $diachi_id, $tongdh)
    {
        $obj = $this->connect->prepare("INSERT INTO donhang(ngaythem, makh, diachi_id, tongdh) VALUES (?,?,?,?)");
        $obj->execute(array($ngaythem, $makh, $diachi_id, $tongdh));
        return $this->connect->lastInsertId();
    }

    public function DonHang__Update($madon, $ngaythem, $makh, $tongdh)
    {
        $obj = $this->connect->prepare("UPDATE donhang SET ngaythem=?, makh=?, tongdh=? WHERE madon=?");
        $obj->execute(array($ngaythem, $makh, $tongdh, $madon));
        return $obj->rowCount();
    }
    public function DonHang__Update_State($madon, $trangthai)
    {
        $obj = $this->connect->prepare("UPDATE donhang SET trangthai=? WHERE madon=?");
        $obj->execute(array($trangthai, $madon));
        return $obj->rowCount();
    }

    public function DonHang__Delete($madon, $trangthai)
    {
        $obj = $this->connect->prepare("UPDATE donhang SET trangthai = ? WHERE madon = ?");
        $obj->execute(array($madon, $trangthai));
        return $obj->rowCount();
    }

    public function DonHang__Get_By_Id($madon)
    {
        $obj = $this->connect->prepare("SELECT * FROM donhang WHERE madon = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($madon));
        return $obj->fetch();
    }
    public function DonHang__Get_By_Id_KH($makh)
    {
        $obj = $this->connect->prepare("SELECT *,  CONCAT('GOAT-', madon, DATE_FORMAT(ngaythem, '%H%i%s')) AS ma_don_hang FROM donhang WHERE makh = ? ");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($makh));
        return $obj->fetchAll();
    }
}
