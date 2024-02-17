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

class LoaiSpModel extends Database
{

    public function LoaiSp__Get_All($trangthai = null)
    {
        if($trangthai == -1){
            $obj = $this->connect->prepare("SELECT * FROM loaisp");
        }else{
            $obj = $this->connect->prepare("SELECT * FROM loaisp WHERE trangthai=1");
        }
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }
    
    public function LoaiSp__Add($tenloai, $mota, $trangthai)
    {
        $obj = $this->connect->prepare("INSERT INTO loaisp(tenloai, mota,trangthai) VALUES (?,?,?)");
        $obj->execute(array($tenloai, $mota, $trangthai));
        return $obj->rowCount();
    }

    public function LoaiSp__Update($maloai, $tenloai, $mota, $trangthai)
    {
        $obj = $this->connect->prepare("UPDATE loaisp SET tenloai=?, mota=?, trangthai=? WHERE maloai=?");
        $obj->execute(array($tenloai, $mota, $trangthai, $maloai));
        return $obj->rowCount();
    }
    public function LoaiSp__Delete($maloai)
    {
        $obj = $this->connect->prepare("DELETE FROM loaisp WHERE maloai = ?");
        $obj->execute(array($maloai));
        return $obj->rowCount();
    }

    public function LoaiSp__Get_By_Id($maloai)
    {
        $obj = $this->connect->prepare("SELECT * FROM loaisp WHERE maloai = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($maloai));
        return $obj->fetch();
    }
}
