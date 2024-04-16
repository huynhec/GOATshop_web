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

class TimeTrackingModel extends Database
{

    public function User_item_tracking__Get_All()
    {
        $obj = $this->connect->prepare("SELECT * FROM user_item_tracking");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }
    public function User_item_tracking__Get_OneD()
    {
        // Lấy ngày hiện tại
        $ngayhientai = date("Y-m-d");

        // Chuẩn bị câu truy vấn với điều kiện ngày xem là ngày hiện tại
        $obj = $this->connect->prepare("SELECT * FROM user_item_tracking WHERE DATE(ngay) = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($ngayhientai));

        // Trả về kết quả
        return $obj->fetchAll();
    }
    public function User_item_tracking__Get_TwoD()
    {
        // Lấy ngày hiện tại
        $ngayhientai = date("Y-m-d");

        // Tính toán ngày 2 ngày trước đó
        $ngaytruocdo = date("Y-m-d", strtotime("-3 days"));

        // Chuẩn bị câu truy vấn với điều kiện ngày xem trong khoảng từ ngày 2 ngày trước đến ngày hiện tại
        $obj = $this->connect->prepare("SELECT * FROM user_item_tracking WHERE DATE(ngay) BETWEEN ? AND ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($ngaytruocdo, $ngayhientai));

        // Trả về kết quả
        return $obj->fetchAll();
    }

    public function User_item_tracking__Add($timeCounter, $masp, $typetrack, $ngay)
    {
        // Kiểm tra xem có bản ghi nào đã tồn tại với cùng typetrack, masp và ngay hay không
        $existingRecord = $this->connect->prepare("
            SELECT * FROM user_item_tracking 
            WHERE masp = ? AND typetrack = ? AND ngay = ?
        ");
        $existingRecord->execute(array($masp, $typetrack, $ngay));
        $rowCount = $existingRecord->rowCount();
    
        if ($rowCount > 0) {
            // Nếu đã tồn tại bản ghi, cập nhật trường thoigian
            $updateRecord = $this->connect->prepare("
                UPDATE user_item_tracking 
                SET thoigian = thoigian + ?
                WHERE masp = ? AND typetrack = ? AND ngay = ?
            ");
            $updateRecord->execute(array($timeCounter, $masp, $typetrack, $ngay));
            return $updateRecord->rowCount();
        } else {
            // Nếu không có bản ghi tồn tại, thêm mới bản ghi
            $newRecord = $this->connect->prepare("
                INSERT INTO user_item_tracking(thoigian, masp, typetrack, ngay) 
                VALUES (?, ?, ?, ?)
            ");
            $newRecord->execute(array($timeCounter, $masp, $typetrack, $ngay));
            return $newRecord->rowCount();
        }
    }

    public function User_item_tracking__Update($maanh, $hinhanh, $masp)
    {
        $obj = $this->connect->prepare("UPDATE user_item_tracking SET hinhanh=?, masp=? WHERE maanh=?");
        $obj->execute(array($hinhanh, $masp, $maanh));
        return $obj->rowCount();
    }
    public function User_item_tracking__Delete($maanh)
    {
        $obj = $this->connect->prepare("DELETE FROM user_item_tracking WHERE maanh = ?");
        $obj->execute(array($maanh));
        return $obj->rowCount();
    }

    public function User_item_tracking__Delete_By_Id_Sp($masp)
    {
        $obj = $this->connect->prepare("DELETE FROM user_item_tracking WHERE masp = ?");
        $obj->execute(array($masp));
        return $obj->rowCount();
    }


    public function User_item_tracking__Get_By_Id($maanh)
    {
        $obj = $this->connect->prepare("SELECT * FROM user_item_tracking WHERE maanh = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($maanh));
        return $obj->fetch();
    }

    public function User_item_tracking__Get_By_Id_Sp($masp)
    {
        $obj = $this->connect->prepare("SELECT DATE(ngay) AS ngay, SUM(thoigian) AS thoigian FROM user_item_tracking WHERE masp = ? GROUP BY DATE(ngay)");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($masp));
        return $obj->fetchAll();
    }
}
