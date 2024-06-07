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

class DiaChiModel extends Database
{

    public function DiaChi__Get_All()
    {
        $obj = $this->connect->prepare("SELECT * FROM diachi");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }
    public function DiaChi__Add($makh, $province, $district, $wards, $road)
    {
        // Kiểm tra xem có bản ghi nào giống với địa chỉ mới không
        $checkQuery = $this->connect->prepare("
            SELECT * 
            FROM diachi 
            WHERE makh = ? 
              AND province = ? 
              AND district = ? 
              AND wards = ? 
              AND road = ?
            LIMIT 1
        ");
        $checkQuery->execute(array($makh, $province, $district, $wards, $road));
        $existingAddress = $checkQuery->fetch(PDO::FETCH_ASSOC);
    
        if (!$existingAddress) {
            // Nếu không có địa chỉ giống, thực hiện chèn dữ liệu mới
            $insertQuery = $this->connect->prepare("
                INSERT INTO diachi(makh, province, district, wards, road) 
                VALUES (?, ?, ?, ?, ?)
            ");
            $insertQuery->execute(array($makh, $province, $district, $wards, $road));
            return $insertQuery->rowCount();
        } else {
            // Nếu có địa chỉ giống, không thực hiện chèn và trả về 0
            return 0;
        }
    }
    

    public function DiaChi__Update($maanh, $hinhanh, $masp)
    {
        $obj = $this->connect->prepare("UPDATE diachi SET hinhanh=?, masp=? WHERE maanh=?");
        $obj->execute(array($hinhanh, $masp, $maanh));
        return $obj->rowCount();
    }
    public function DiaChi__Delete($maanh)
    {
        $obj = $this->connect->prepare("DELETE FROM diachi WHERE maanh = ?");
        $obj->execute(array($maanh));
        return $obj->rowCount();
    }

    public function DiaChi__Delete_By_Id_Sp($masp)
    {
        $obj = $this->connect->prepare("DELETE FROM diachi WHERE masp = ?");
        $obj->execute(array($masp));
        return $obj->rowCount();
    }


    public function DiaChi__Get_By_Id($makh)
    {
        $obj = $this->connect->prepare("SELECT * FROM diachi WHERE makh = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($makh));
        return $obj->fetch();
    }

    public function DiaChi__Get_By_Id_Sp($masp)
    {
        $obj = $this->connect->prepare("SELECT * FROM diachi WHERE masp = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($masp));
        return $obj->fetchAll();
    }

    public function DiaChi__Get_By_Id_Sp_First($masp)
    {
        $obj = $this->connect->prepare("SELECT * FROM diachi WHERE masp = ? ORDER BY maanh ASC LIMIT 1");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($masp));
        return $obj->fetch();
    }
    public function DiaChi__Get_By_Id_Sp_Not_First($masp)
    {
        $maanh = $this->DiaChi__Get_By_Id_Sp_First($masp)->maanh;
        $obj = $this->connect->prepare("SELECT * FROM diachi WHERE masp = ? AND maanh !=? ORDER BY maanh ASC");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($masp, $maanh));
        return $obj->fetchAll();
    }

    public function DiaChi__Get_By_Id_Kh($makh, $des = null)
    {
        if ($des != null) {
            $obj = $this->connect->prepare("SELECT * FROM `$des` WHERE `name` IN (SELECT `$des` FROM `diachi` WHERE `makh` = ?) ");
        } else {
            $obj = $this->connect->prepare("SELECT * FROM `diachi` WHERE `makh` = ? ORDER BY `diachi_id` DESC LIMIT 1");
        }
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($makh));
        return $obj->fetch();
    }
    public function Road__Get_By_Id_Kh($makh)
    {
        $obj = $this->connect->prepare("SELECT * FROM `diachi` WHERE `makh` = ? ORDER BY `diachi_id` ASC LIMIT 1");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($makh));
        return $obj->fetch();
    }
    // nối chuỗi 
    public function DiaChi__Get_By_Full_Ad($diachi_id)
    {
        $obj = $this->connect->prepare("SELECT CONCAT_WS(', ' ,`road`,`wards`,`district`,`province`) AS full_dc FROM `diachi` WHERE `diachi_id`= ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($diachi_id));
        return $obj->fetch();
    }
}
