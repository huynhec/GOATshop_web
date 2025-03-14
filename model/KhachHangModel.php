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

class KhachHangModel extends Database
{

    public function KhachHang__Get_All($trangthai = null)
    {
        if ($trangthai != -1) {
            $obj = $this->connect->prepare("SELECT * FROM khachhang");
        } else {
            $obj = $this->connect->prepare("SELECT * FROM khachhang");
        }
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }

    public function KhachHang__Get_By_Id($makh)
    {
        $obj = $this->connect->prepare("SELECT khachhang.*, users.username, users.password FROM khachhang INNER JOIN users ON khachhang.mauser = users.mauser WHERE makh = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($makh));
        return $obj->fetch();
    }

    public function KhachHang__Add($tenhienthi, $gioitinh, $ngaysinh, $sodienthoai, $province, $district, $wards, $road, $email, $username, $password, $trangthai)
    {
        // Thêm người dùng vào bảng users
        $obj = $this->connect->prepare("INSERT INTO users (tenhienthi, username, password, phanquyen, trangthai)
                                    VALUES (?, ?, ?, 3 , ?)");
        $obj->execute(array($tenhienthi, $username, $password, $trangthai));

        // Lấy mauser vừa được thêm
        $mauser = $this->connect->lastInsertId();

        // Thêm thông tin khách hàng vào bảng khachhang
        $obj = $this->connect->prepare("INSERT INTO khachhang (tenkh, gioitinh, ngaysinh, sodienthoai, email, trangthai, mauser)
                                    VALUES (?, ?, ?, ?, ?, ?, ?)");
        $obj->execute(array($tenhienthi, $gioitinh, $ngaysinh, $sodienthoai, $email, $trangthai, $mauser));

        // Lấy makh vừa được thêm
        $makh = $this->connect->lastInsertId();

        // Thêm địa chỉ của khách hàng vào bảng diachi
        $obj = $this->connect->prepare("INSERT INTO diachi (makh, province, district, wards, road)
                                    VALUES (?, ?, ?, ?, ?)");
        $obj->execute(array($makh, $province, $district, $wards, $road));

        // Trả về số hàng đã được thêm vào bảng khachhang
        return $obj->rowCount();
    }


    public function KhachHang__Check_Email($email)
    {
        $obj = $this->connect->prepare("SELECT * FROM khachhang WHERE email = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($email));
        if ($obj->rowCount() > 0) {
            return false;
        } else {
            return true;
        }
    }
    public function KhachHang__Check_Exist_Email($email)
    {
        $obj = $this->connect->prepare("SELECT * FROM khachhang WHERE email = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($email));
        if ($obj->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function KhachHang__Save_Token($token, $email)
    {
        $time = date('Y-m-d H:i:s', strtotime('+ 5 minutes'));
        $obj = $this->connect->prepare("UPDATE khachhang SET reset_token = ?, reset_token_expire = ? WHERE email = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($token, $time, $email));
        return $obj->rowCount();
    }

    public function KhachHang__Dang_Nhap($emailOrUsername, $password)
    {
        // Kiểm tra xem đầu vào có phải là email hay username
        if (filter_var($emailOrUsername, FILTER_VALIDATE_EMAIL)) {
            $sql = "SELECT * FROM khachhang INNER JOIN users ON khachhang.mauser = users.mauser WHERE khachhang.email = ? AND users.password = ? AND khachhang.trangthai = 1";
        } else {
            $sql = "SELECT * FROM users INNER JOIN khachhang ON users.mauser = khachhang.mauser WHERE users.username = ? AND users.password = ? AND users.trangthai = 1";
        }

        $obj = $this->connect->prepare($sql);
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($emailOrUsername, $password));

        if ($obj->rowCount() > 0) {
            return $obj->fetch();
        } else {
            return false;
        }
    }

    public function KhachHang__Update($makh, $tenkh, $username, $gioitinh, $ngaysinh, $sodienthoai, $email, $password, $trangthai)
    {
        $obj = $this->connect->prepare("UPDATE khachhang kh JOIN users u ON kh.mauser = u.mauser 
        SET kh.tenkh=?, u.username=?, kh.gioitinh=?, kh.ngaysinh=?, kh.sodienthoai=?, kh.email=?, u.password=?, kh.trangthai=?, u.trangthai=? WHERE kh.makh=?");
        $obj->execute(array($tenkh, $username, $gioitinh, $ngaysinh, $sodienthoai, $email, $password, $trangthai, $trangthai, $makh));
        return $obj->rowCount();
    }

    public function KhachHang__Update_Info($makh, $tenkh, $sodienthoai, $email)
    {
        $obj = $this->connect->prepare("UPDATE khachhang SET tenkh=?, sodienthoai=?, email=? WHERE makh=?");
        $obj->execute(array($tenkh, $sodienthoai, $email, $makh));
        return $obj->rowCount();
    }

    public function KhachHang__Delete($makh, $trangthai)
    {
        $obj = $this->connect->prepare("UPDATE khachhang SET trangthai=? WHERE makh=?");
        $obj->execute(array($trangthai, $makh));
        return $obj->rowCount();
    }
    public function XacMinh_Token($token, $date)
    {
        $obj = $this->connect->prepare("SELECT * FROM khachhang WHERE reset_token = (?) AND reset_token_expire > (?) ");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($token, $date));
        // return $obj->fetch();
        if ($obj->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function Update_Password($password, $token)
    {
        $obj = $this->connect->prepare("UPDATE users
            INNER JOIN khachhang ON users.mauser = khachhang.mauser
            SET users.password = ?, khachhang.reset_token = NULL, khachhang.reset_token_expire = NULL
            WHERE khachhang.reset_token = ? ;");
        $obj->execute(array($password, $token));
        return $obj->rowCount();
    }
}
