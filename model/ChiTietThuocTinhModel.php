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

class ChiTietThuocTinhModel extends Database
{

    public function ChiTietThuocTinh__Get_All()
    {
        $obj = $this->connect->prepare("SELECT * FROM chitietthuoctinh");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }
    public function ChiTietThuocTinh__Add($idtt, $masp, $noidung)
    {
        $obj = $this->connect->prepare("INSERT INTO chitietthuoctinh(idtt,masp, noidung) VALUES (?,?,?)");
        $obj->execute(array($idtt, $masp, $noidung));
        return $obj->rowCount();
    }

    public function ChiTietThuocTinh__Update($id_cttt, $idtt, $masp, $noidung)
    {
        $obj = $this->connect->prepare("UPDATE chitietthuoctinh SET idtt=?, masp=?, noidung=? WHERE id_cttt=?");
        $obj->execute(array($idtt, $masp, $noidung, $id_cttt));
        return $obj->rowCount();
    }

    public function ChiTietThuocTinh__Delete($id_cttt)
    {
        $obj = $this->connect->prepare("DELETE FROM chitietthuoctinh WHERE id_cttt = ?");
        $obj->execute(array($id_cttt));

        return $obj->rowCount();
    }

    public function ChiTietThuocTinh__Get_By_Id($id_cttt)
    {
        $obj = $this->connect->prepare("SELECT * FROM chitietthuoctinh WHERE id_cttt = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($id_cttt));
        return $obj->fetch();
    }
}
