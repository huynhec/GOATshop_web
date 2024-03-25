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

class DonGiaModel extends Database
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
        $obj = $this->connect->prepare("UPDATE dongia SET apdung = 0 WHERE masp = ? ");
        $obj->execute(array($masp));

        $obj = $this->connect->prepare("INSERT INTO dongia(dongia, apdung, ngaynhap, masp) VALUES (?,?,?,?)");
        $obj->execute(array($dongia, $apdung, $ngaynhap, $masp));
        return $obj->rowCount();
    }

    public function DonGia__Update($dongia, $apdung, $ngaynhap, $masp, $id_dongia)
    {
        $obj = $this->connect->prepare("UPDATE dongia SET dongia=?, apdung=?, ngaynhap=?, masp=? WHERE id_dongia=?");
        $obj->execute(array($dongia, $apdung, $ngaynhap, $masp, $id_dongia));
        return $obj->rowCount();
    }
    public function DonGia__Update_ApDung($masp, $id_dongia)
    {
        // Cập nhật tất cả các bản ghi 'apdung' trong bảng 'dongia' thành 0
        $stmt = $this->connect->prepare("UPDATE dongia SET apdung = 0 WHERE masp = ? ");
        $stmt->execute(array($masp));

        // Cập nhật bản ghi 'apdung' của 'id_dongia' thành 1
        $stmt = $this->connect->prepare("UPDATE dongia SET apdung = 1 WHERE id_dongia = ?");
        $stmt->execute([$id_dongia]);
        return true;

    }

    public function DonGia__Delete($id_dongia)
    {
        $obj = $this->connect->prepare("DELETE FROM dongia WHERE id_dongia = ?");
        $obj->execute(array($id_dongia));
        return $obj->rowCount();
    }

    public function DonGia__Get_By_Id($id_dongia)
    {
        $obj = $this->connect->prepare("SELECT * FROM dongia WHERE id_dongia= ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($id_dongia));
        return $obj->fetch();
    }

    public function DonGia__Get_By_Id_Sp($masp)
    {
        $obj = $this->connect->prepare("SELECT * FROM dongia INNER JOIN sanpham ON dongia.masp = sanpham.masp WHERE dongia.masp=?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($masp));
        return $obj->fetchAll();
    }
    public function ShowDonGia__Get_By_Id_Sp($masp)
    {
        $obj = $this->connect->prepare("SELECT * FROM dongia INNER JOIN sanpham ON dongia.masp = sanpham.masp WHERE dongia.apdung=1 AND masp=?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($masp));
        return $obj->fetchAll(); // Trả về giá trị đơn giá
    }

    public function ShowDonGia__Get_By_Id_Spdg($masp)
    {
        $obj = $this->connect->prepare("SELECT * FROM dongia WHERE masp= ? AND apdung =1 ORDER BY id_dongia DESC LIMIT 1");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($masp));
        $dongia = $obj->fetch(PDO::FETCH_OBJ); // Lấy dòng đơn giá duy nhất từ kết quả truy vấn
        return $dongia->dongia; // Trả về giá trị đơn giá
    }

    // public function ShowDonGia__Get_By_Id_Not_Spdg($masp)
    // {
    //     $id_dongia = $this->ShowDonGia__Get_By_Id_Spdg($masp)->id_dongia;
    //     $obj = $this->connect->prepare("SELECT * FROM dongia WHERE masp = ? AND id_dongia !=? ORDER BY id_dongia ASC");
    //     $obj->setFetchMode(PDO::FETCH_OBJ);
    //     $obj->execute(array($masp, $id_dongia));
    //     return $obj->fetchAll();
    // }
}

// gc: 100
// gm: 90
// gm<gc ?
// |(gc-gm)|*100% = -10% : ''