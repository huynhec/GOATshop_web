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

    public function Size__Get_All($trangthai = null)
    {
        if ($trangthai == -1) {
            $obj = $this->connect->prepare("SELECT * FROM kichco");
        } else {
            $obj = $this->connect->prepare("SELECT * FROM kichco WHERE trangthai=1");
        }
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }
    public function Size__Get_By_Id_Loai($maloai)
    {
        $obj = $this->connect->prepare("SELECT kichco.idsize, kichco.tensize, kichco.trangthai, loaisp.maloai, loaisp.tenloai, loaisp.mota, loaisp.ghichu
        FROM kichco
        INNER JOIN loaisp ON kichco.maloai = loaisp.maloai WHERE kichco.maloai=? ");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($maloai));
        return $obj->fetchAll();
    }

    public function Size__Add($tensize, $trangthai, $maloai)
    {
        $obj = $this->connect->prepare("INSERT INTO kichco(tensize, trangthai, maloai) VALUES (?,?,?)");
        $obj->execute(array($tensize, $trangthai, $maloai));
        return $obj->rowCount();
    }

    public function Size__Update($tensize,  $trangthai, $maloai, $idsize)
    {
        $obj = $this->connect->prepare("UPDATE kichco SET tensize=?,  trangthai=?, maloai=? WHERE idsize=?");
        $obj->execute(array($tensize,  $trangthai, $maloai, $idsize));
        return $obj->rowCount();
    }
    public function Size__Delete($idtt)
    {
        $obj = $this->connect->prepare("DELETE FROM kichco WHERE idsize = ?");
        $obj->execute(array($idtt));
        return $obj->rowCount();
    }

    public function Size__Get_By_Id($idsize)
    {
        $obj = $this->connect->prepare("SELECT * FROM kichco WHERE idsize= ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($idsize));
        return $obj->fetch();
    }
}
