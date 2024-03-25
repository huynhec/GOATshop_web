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

class ThuocTinhModel extends Database
{

    public function ThuocTinh__Get_All($trangthai = null)
    {
        if ($trangthai == -1) {
            $obj = $this->connect->prepare("SELECT * FROM thuoctinh");
        } else {
            $obj = $this->connect->prepare("SELECT * FROM thuoctinh WHERE trangthai=1");
        }
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }
    public function ThuocTinh__Get_By_Id_Loai($maloai)
    {
        $obj = $this->connect->prepare("SELECT * FROM thuoctinh WHERE maloai = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($maloai));
        return $obj->fetchAll();
    }
    public function ThuocTinh__Add($tentt, $trangthai, $is_num, $maloai)
    {
        $obj = $this->connect->prepare("INSERT INTO thuoctinh(tentt, trangthai, is_num, maloai) VALUES (?,?,?,?)");
        $obj->execute(array($tentt, $trangthai, $is_num, $maloai));
        return $obj->rowCount();
    }

    public function ThuocTinh__Update($tentt, $trangthai, $is_num, $maloai, $idtt)
    {
        $obj = $this->connect->prepare("UPDATE thuoctinh SET tentt=?, trangthai=?, is_num=?, maloai=? WHERE idtt=?");
        $obj->execute(array($tentt, $trangthai, $is_num, $maloai, $idtt));
        return $obj->rowCount();
    }
    public function ThuocTinh__Delete($idtt)
    {
        $obj = $this->connect->prepare("DELETE FROM thuoctinh WHERE idtt = ?");
        $obj->execute(array($idtt));
        return $obj->rowCount();
    }

    public function ThuocTinh__Get_By_Id($idtt)
    {
        $obj = $this->connect->prepare("SELECT * FROM thuoctinh WHERE idtt= ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($idtt));
        return $obj->fetch();
    }

    public function ThuocTinh__Get_By_Id_Sp($masp)
    {
        $obj = $this->connect->prepare("SELECT * FROM thuoctinh INNER JOIN chitietthuoctinh ON thuoctinh.idtt = chitietthuoctinh.idtt WHERE masp=?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($masp));
        return $obj->fetchAll();
    }
}
