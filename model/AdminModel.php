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

class AdminModel extends Database
{

    public function Admin__Get_All($trangthai = null)
    {
        if ($trangthai != -1) {
            $obj = $this->connect->prepare("SELECT admin.*, users.phanquyen FROM nhanvien JOIN users ON admin.mauser = users.mauser ");
        } else {
            $obj = $this->connect->prepare("SELECT admin.*, users.phanquyen FROM nhanvien JOIN users ON admin.mauser = users.mauser WHERE admin.trangthai=1 ");
        }
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }

    public function Admin__Add($tenhienthi, $gioitinh, $ngaysinh, $sodienthoai, $diachi, $email, $password, $username, $trangthai, $phanquyen)
    {
        // Thêm người dùng vào bảng users
        $obj = $this->connect->prepare("INSERT INTO users (tenhienthi, username, password, phanquyen, trangthai)
                VALUES (?, ?, ?, ? , ?)");
        $obj->execute(array($tenhienthi, $username, $password, $phanquyen, $trangthai));

        // Lấy mauser vừa được thêm
        $mauser = $this->connect->lastInsertId();

        $obj = $this->connect->prepare("INSERT INTO admin(tennv, gioitinh, ngaysinh, sodienthoai, diachi, email, trangthai, mauser) VALUES (?,?,?,?,?,?,?,?)");
        $obj->execute(array($tenhienthi, $gioitinh, $ngaysinh, $sodienthoai, $diachi, $email, $trangthai, $mauser));
        return $obj->rowCount();
    }

    public function Admin__Check_Email($email)
    {
        $obj = $this->connect->prepare("SELECT * FROM admin WHERE email = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($email));
        if ($obj->rowCount() > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function Admin__Get_By_Id($adminID)
    {
        $obj = $this->connect->prepare("SELECT * FROM admin WHERE adminID = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($adminID));
        return $obj->fetch();
    }


    public function Admin__Dang_Nhap($emailOrUsername, $password)
    {
        // Kiểm tra xem đầu vào có phải là email hay username
        if (filter_var($emailOrUsername, FILTER_VALIDATE_EMAIL)) {
            $sql = "SELECT users.*, admin.* FROM admin INNER JOIN users ON admin.mauser = users.mauser WHERE admin.email = ? AND users.password = ?";
        } else {
            $sql = "SELECT users.*, admin.* FROM users INNER JOIN admin ON users.mauser = admin.mauser WHERE users.username = ? AND users.password = ?";
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

    public function Admin__Update($adminID, $tennv, $username, $gioitinh, $ngaysinh, $sodienthoai, $diachi, $email, $password, $trangthai, $phanquyen)
    {
        $obj = $this->connect->prepare("UPDATE admin ad JOIN users u ON ad.mauser = u.mauser 
                SET ad.tenadmin=?, u.username=?, ad.gioitinh=?, ad.ngaysinh=?, ad.sodienthoai=?, ad.diachi=?, ad.email=?, u.password=?, ad.trangthai=?, u.trangthai=?, u.phanquyen=? WHERE ad.adminID=?");
        $obj->execute(array($tennv, $username, $gioitinh, $ngaysinh, $sodienthoai, $diachi, $email, $password, $trangthai, $trangthai, $phanquyen, $adminID));
        return $obj->rowCount();
    }
}
