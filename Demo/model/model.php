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

class Model extends Database
{
    public function TaiKhoan__Get_All()
    {
        $obj = $this->connect->prepare("SELECT * FROM users");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }

    public function TaiKhoan__Add($tenhienthi, $username, $password, $trangthai)
    {
        $obj = $this->connect->prepare("INSERT INTO users (tenhienthi, username, password, trangthai) VALUES (?, ?, ?, ?)");
        $values = [$tenhienthi, $username, $password, $trangthai];
        $obj->execute($values);
        return $obj->rowCount();
    }

    public function TaiKhoan__Update($tenhienthi, $username, $password, $trangthai, $tai_khoan_id)
    {
        $obj = $this->connect->prepare("UPDATE users SET tenhienthi = ?, username = ?, password = ?, trangthai = ? WHERE tai_khoan_id = ?");
        $obj->execute([$tenhienthi, $username, $password, $trangthai, $tai_khoan_id]);
        return $obj->rowCount();
    }

    public function TaiKhoan__Delete($tai_khoan_id)
    {
        $obj = $this->connect->prepare("DELETE FROM users WHERE tai_khoan_id = ?");
        $obj->execute([$tai_khoan_id]);
        return $obj->rowCount();
    }

    public function TaiKhoan__Get_By_Id($tai_khoan_id)
    {
        $obj = $this->connect->prepare("SELECT * FROM users WHERE tai_khoan_id = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute([$tai_khoan_id]);
        return $obj->fetch();
    }

    public function TaiKhoan__Get_By_Phan_Quyen()
    {
        $obj = $this->connect->prepare("");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array());
        return $obj->fetch();
    }

    public function Login($username,$password)
    {
        $obj = $this->connect->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($username,$password));
        if ($obj->rowCount() > 0) {
            return $obj->fetch();
        } else {
            return 0;
        }
    }

    public function TaiKhoan__Ma_Hoa_Mat_Khau($mat_khau)
    {
        $ciphering = "AES-128-CTR";
        $options = 0;
        $encryption_iv = '1234567891011121';
        $encryption_key = "W3docs";
        $encryption = openssl_encrypt($mat_khau, $ciphering, $encryption_key, $options, $encryption_iv);
        return $encryption;
    }

    public function TaiKhoan__Giai_Ma_Mat_Khau($mat_khau_ma_hoa)
    {
        $ciphering = "AES-128-CTR";
        $options = 0;
        $decryption_iv = '1234567891011121';
        $decryption_key = "W3docs";
        $decryption = openssl_decrypt($mat_khau_ma_hoa, $ciphering, $decryption_key, $options, $decryption_iv);
        return $decryption;
    }
}
