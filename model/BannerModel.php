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

class BannerModel extends Database
{

    public function Banner__Get_All($trangthai)
    {
        if ($trangthai != -1) {
            $obj = $this->connect->prepare("SELECT * FROM banner");
        } else {
            $obj = $this->connect->prepare("SELECT * FROM banner");
        }
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }

    public function Banner__Show()
    {
        $obj = $this->connect->prepare("SELECT * FROM banner WHERE trangthai = 1");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }

    public function Banner__Add($tenbanner, $anhbanner, $trangthai)
    {
        $obj = $this->connect->prepare("INSERT INTO banner(tenbanner, anhbanner, trangthai) VALUES (?,?,?)");
        $obj->execute(array($tenbanner, $anhbanner, $trangthai));
        return $this->connect->lastInsertId();
    }

    public function Banner__Update($id_banner, $tenbanner, $trangthai)
    {
        $obj = $this->connect->prepare("UPDATE banner SET tenbanner=?, trangthai=? WHERE id_banner=?");
        $obj->execute(array($tenbanner, $trangthai, $id_banner));
        return $obj->rowCount();
    }
    public function Anh_Banner__Update($id_banner, $anhbanner)
    {
        $obj = $this->connect->prepare("UPDATE banner SET anhbanner=? WHERE id_banner=?");
        $obj->execute(array($anhbanner, $id_banner));
        return $obj->rowCount();
    }
    public function Folder_Banner__Get_by_Id($id_banner)
    {
        $obj = $this->connect->prepare("SELECT 
            id_banner, 
            tenbanner, 
            SUBSTRING_INDEX(SUBSTRING_INDEX(anhbanner, '/', 2), '/', -1) AS truncated_anhbanner, 
            trangthai 
            FROM banner
            WHERE id_banner = ?;");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array( $id_banner));
        return $obj->fetch();
    }

    public function Banner__Delete($id_banner)
    {
        $obj = $this->connect->prepare("DELETE FROM banner WHERE id_banner = ?");
        $obj->execute(array($id_banner));

        return $obj->rowCount();
    }

    public function Banner__Get_By_Id($id_banner)
    {
        $obj = $this->connect->prepare("SELECT * FROM banner WHERE id_banner = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($id_banner));
        return $obj->fetch();
    }

    public function Anh_Banner__Get_By_Id_Sp_First($id_banner)
    {
        $obj = $this->connect->prepare("SELECT * FROM banner WHERE id_banner = ? ORDER BY id_banner ASC LIMIT 1");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($id_banner));
        return $obj->fetch();
    }
}
