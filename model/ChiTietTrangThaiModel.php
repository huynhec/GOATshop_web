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

class ChiTietTrangThaiModel extends Database
{

    public function ChiTietTrangThai__Get_All()
    {
        $obj = $this->connect->prepare("SELECT * FROM chitiettrangthai");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }
    public function ChiTietTrangThai__Add($madon, $matt, $manv, $ngaytao)
    {
        $obj = $this->connect->prepare("INSERT INTO chitiettrangthai(madon, matt, manv, ngaytao) VALUES (?,?,?,?)");
        $obj->execute(array($madon, $matt, $manv, $ngaytao));
        return $obj->rowCount();
    }

    public function ChiTietTrangThai__Update($machitiet, $madon, $matt, $manv, $ngaytao)
    {
        $obj = $this->connect->prepare("UPDATE chitiettrangthai SET madon=?, matt=?, manv=?, ngaytao=? WHERE machitiet=?");
        $obj->execute(array($madon, $matt, $manv, $ngaytao, $machitiet));
        return $obj->rowCount();
    }
    
    public function ChiTietTrangThai__Delete($machitiet)
    {
        $obj = $this->connect->prepare("DELETE FROM chitiettrangthai WHERE machitiet = ?");
        $obj->execute(array($machitiet));

        return $obj->rowCount();
    }

    public function ChiTietTrangThai__Get_By_Id($machitiet)
    {
        $obj = $this->connect->prepare("SELECT * FROM chitiettrangthai WHERE machitiet = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($machitiet));
        return $obj->fetch();
    }

    public function ChiTietTrangThai__Get_By_Id_DH($madon)
    {
        $obj = $this->connect->prepare("SELECT * FROM chitiettrangthai WHERE madon = ? ORDER BY machitiet DESC");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($madon));
        return $obj->fetchAll();
    }

    public function ChiTietTrangThai__Get_Last_By_DH($madon)
    {
        $obj = $this->connect->prepare("SELECT * FROM chitiettrangthai INNER JOIN trangthai ON chitiettrangthai.matt = trangthai.matt WHERE madon = ? ORDER BY chitiettrangthai.matt DESC LIMIT 1");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($madon));
        return $obj->fetch();
    }

    public function ChiTietTrangThai__Get_Sum_Chart()
    {
        $obj = $this->connect->prepare("SELECT *, COUNT(chitiettrangthai.madon) AS sumtt FROM chitiettrangthai INNER JOIN trangthai ON chitiettrangthai.matt = trangthai.matt GROUP BY chitiettrangthai.matt");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }

    public function ChiTietTrangThai__Check($madon, $matt)
    {
        $obj = $this->connect->prepare("SELECT * FROM chitiettrangthai WHERE madon = ? AND matt=?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($madon, $matt));
        if($obj->rowCount()>0){
            return $obj->fetch();
        }else{
            return false;
        }
    }
}