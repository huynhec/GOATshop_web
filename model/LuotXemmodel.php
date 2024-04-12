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

class LuotXemModel extends Database
{

    public function LuotXem__Get_All($trangthai)
    {
        if ($trangthai != -1) {
            $obj = $this->connect->prepare("SELECT * FROM luotxem");
        } else {
            $obj = $this->connect->prepare("SELECT * FROM luotxem ");
        }
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }

    public function LuotXem__Get_By_Id($masp)
    {
        $obj = $this->connect->prepare("SELECT * FROM luotxem WHERE masp = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($masp));
        return $obj->fetch();
    }



    public function LuotXem__Add($masp)
    {
        // Tạo giá trị cho luotxem và ngayxem
        $luotxem = 1; // Giá trị mặc định cho số lượt xem mới
        $ngayxem = date("Y-m-d H:i:s"); // Thời gian hiện tại

        // Thực hiện thêm vào bảng luotxem
        $obj = $this->connect->prepare("INSERT INTO luotxem(luotxem, ngayxem, masp) VALUES (?,?,?)");
        $obj->execute(array($luotxem, $ngayxem, $masp));

        // Trả về ID của bản ghi vừa được thêm vào
        return $this->connect->lastInsertId();
    }


    // public function LuotXem__Increase_View_Count($masp)
    // {
    //     // Tăng số lần xem
    //     $sql = "UPDATE luotxem SET luotxem = luotxem + 1 WHERE masp = ?";
    //     $obj = $this->connect->prepare($sql);
    //     $obj->execute(array($masp));

    //     // Kiểm tra xem câu lệnh UPDATE có thành công hay không
    //     if ($obj->rowCount() > 0) {
    //         // Nếu thành công, lấy số lần xem mới
    //         $newViewCount = $this->LuotXem__Get_View_Count($masp);
    //         return $newViewCount;
    //     } else {
    //         // Nếu không thành công, trả về false
    //         return false;
    //     }
    // }

    // public function LuotXem__Get_View_Count($masp)
    // {
    //     // Truy vấn số lần xem
    //     $sql = "SELECT luotxem FROM luotxem WHERE masp = ?";
    //     $obj = $this->connect->prepare($sql);
    //     $obj->execute(array($masp));
    //     $result = $obj->fetch(PDO::FETCH_OBJ);

    //     // Kiểm tra xem có kết quả được tìm thấy không
    //     return ($result) ? $result->luotxem : 0;
    // }
}