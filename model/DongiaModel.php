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

class DongiaModel extends Database
{

    public function DonGia__Get_All($apdung = null)
    {
        if ($apdung == -1) {
            $obj = $this->connect->prepare("SELECT * FROM dongia");
        } else {
            $obj = $this->connect->prepare("SELECT * FROM dongia WHERE apdung=1");
        }
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }

    public function DonGia__Add($dongia, $apdung, $ngaynhap, $masp)
    {
        $obj = $this->connect->prepare("INSERT INTO dongia(dongia, apdung, ngaynhap, masp) VALUES (?,?,?,?)");
        $obj->execute(array($dongia, $apdung, $ngaynhap, $masp));
        return $obj->rowCount();
    }

    public function DonGia__Update($dongia, $apdung, $ngaynhap, $masp, $iddg)
    {
        $obj = $this->connect->prepare("UPDATE dongia SET dongia=?, apdung=?, ngaynhap=?, masp=? WHERE id_dongia=?");
        $obj->execute(array($dongia, $apdung, $ngaynhap, $masp, $iddg));
        return $obj->rowCount();
    }
    public function DonGia__Delete($iddg)
    {
        $obj = $this->connect->prepare("DELETE FROM dongia WHERE id_dongia = ?");
        $obj->execute(array($iddg));
        return $obj->rowCount();
    }

    public function DonGia__Get_By_Id($iddg)
    {
        $obj = $this->connect->prepare("SELECT * FROM dongia WHERE id_dongia= ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($iddg));
        return $obj->fetch();
    }

    public function DonGia__Get_By_Id_Sp($masp)
    {
        $obj = $this->connect->prepare("SELECT * FROM dongia INNER JOIN sanpham ON dongia.masp = sanpham.masp WHERE apdung=1 AND masp=?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($masp));
        return $obj->fetchAll();
    }
    public function ShowDonGia__Get_By_Id_Sp($masp)
    {
        $obj = $this->connect->prepare("SELECT * FROM dongia INNER JOIN sanpham ON dongia.masp = sanpham.masp WHERE dongia.apdung=1 AND dongia.masp=?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($masp));
        $dongia = $obj->fetch(PDO::FETCH_OBJ); // Lấy dòng đơn giá duy nhất từ kết quả truy vấn
        return $dongia->dongia; // Trả về giá trị đơn giá
    }
}
