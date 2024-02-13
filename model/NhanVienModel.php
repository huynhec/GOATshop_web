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

class NhanVienModel extends Database
{

    public function NhanVien__Get_All($trangthai = null)
    {
        if ($trangthai != -1) {
            $obj = $this->connect->prepare("SELECT nhanvien.*, users.phanquyen FROM nhanvien JOIN users ON nhanvien.mauser = users.mauser ");
        } else {
            $obj = $this->connect->prepare("SELECT nhanvien.*, users.phanquyen FROM nhanvien JOIN users ON nhanvien.mauser = users.mauser  ");
        }
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }

    public function NhanVien__Add($tenhienthi, $gioitinh, $ngaysinh, $sodienthoai, $diachi, $email, $password, $username, $trangthai, $phanquyen)
    {
        // Thêm người dùng vào bảng users
        $obj = $this->connect->prepare("INSERT INTO users (tenhienthi, username, password, phanquyen, trangthai)
                VALUES (?, ?, ?, ? , ?)");
        $obj->execute(array($tenhienthi, $username, $password, $phanquyen, $trangthai));

        // Lấy mauser vừa được thêm
        $mauser = $this->connect->lastInsertId();

        $obj = $this->connect->prepare("INSERT INTO nhanvien(tennv, gioitinh, ngaysinh, sodienthoai, diachi, email, trangthai, mauser) VALUES (?,?,?,?,?,?,?,?)");
        $obj->execute(array($tenhienthi, $gioitinh, $ngaysinh, $sodienthoai, $diachi, $email, $trangthai, $mauser));
        return $obj->rowCount();
    }

    public function NhanVien__Check_Email($email)
    {
        $obj = $this->connect->prepare("SELECT * FROM nhanvien WHERE email = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($email));
        if ($obj->rowCount() > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function NhanVien__Get_By_Id($manv)
    {
        $obj = $this->connect->prepare("SELECT * FROM nhanvien WHERE manv = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($manv));
        return $obj->fetch();
    }


    public function NhanVien__Dang_Nhap($emailOrUsername, $password)
    {
        // Kiểm tra xem đầu vào có phải là email hay username
        if (filter_var($emailOrUsername, FILTER_VALIDATE_EMAIL)) {
            $sql = "SELECT users.*, nhanvien.* FROM nhanvien INNER JOIN users ON nhanvien.mauser = users.mauser WHERE nhanvien.email = ? AND users.password = ? AND nhanvien.trangthai = 1";
        } else {
            $sql = "SELECT users.*, nhanvien.* FROM users INNER JOIN nhanvien ON users.mauser = nhanvien.mauser WHERE users.username = ? AND users.password = ? AND users.trangthai = 1";
        }

        $obj = $this->connect->prepare($sql);
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($emailOrUsername, $password));
        if ($obj->rowCount() > 0) {
            return $obj->fetch();
        } else {
            return 0;
        }
    }

    public function NhanVien__Update($manv, $tennv, $username, $gioitinh, $ngaysinh, $sodienthoai, $diachi, $email, $password, $trangthai, $phanquyen)
    {
        $obj = $this->connect->prepare("UPDATE nhanvien nv JOIN users u ON nv.mauser = u.mauser 
                SET nv.tennv=?, u.username=?, nv.gioitinh=?, nv.ngaysinh=?, nv.sodienthoai=?, nv.diachi=?, nv.email=?, u.password=?, nv.trangthai=?, u.trangthai=?, u.phanquyen=? WHERE nv.manv=?");
        $obj->execute(array($tennv, $username, $gioitinh, $ngaysinh, $sodienthoai, $diachi, $email, $password, $trangthai, $trangthai, $phanquyen, $manv));
        return $obj->rowCount();
    }

    public function NhanVien__Delete($manv)
    {
        $obj = $this->connect->prepare("DELETE nhanvien, users FROM nhanvien  JOIN users ON nhanvien.mauser = users.mauser WHERE nhanvien.manv = ? ");
        $obj->execute(array($manv));
        return $obj->rowCount();
    }
}
