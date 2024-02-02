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

class DoanhMucModel extends Database
{

    public function DoanhMuc__Get_All()
    {
        $obj = $this->connect->prepare("SELECT * FROM loaisanpham");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }
    public function DoanhMuc__Add($tenloai, $mota)
    {
        $obj = $this->connect->prepare("INSERT INTO loaisanpham(tenloai, mota) VALUES (?,?)");
        $obj->execute(array($tenloai, $mota));
        return $obj->rowCount();
    }

    public function TheLoai__Update($maloai, $tenloai, $mota)
    {
        $obj = $this->connect->prepare("UPDATE loaisanpham SET tenloai=?, mota=? WHERE maloai=?");
        $obj->execute(array($tenloai, $mota, $maloai));
        return $obj->rowCount();
    }
    public function DoanhMuc__Delete($maloai)
    {
        $obj = $this->connect->prepare("DELETE FROM loaisanpham WHERE maloai = ?");
        $obj->execute(array($maloai));
        return $obj->rowCount();
    }

    public function DoanhMuc__Get_By_Id($maloai)
    {
        $obj = $this->connect->prepare("SELECT * FROM loaisanpham WHERE maloai = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($maloai));
        return $obj->fetch();
    }
    // public function DoanhMuc__Get_Top_View_Chart()
    // {
    //     $sql = "
    //         SELECT
    //             tl.the_loai_id,
    //             tl.the_loai_ten,
    //             SUM(t.truyen_luot_xem) as tong_luot_xem
    //         FROM
    //             the_loai tl
    //         LEFT JOIN
    //             truyen_the_loai ttl ON tl.the_loai_id = ttl.the_loai_id
    //         LEFT JOIN
    //             truyen t ON ttl.truyen_id = t.truyen_id
    //         GROUP BY
    //             tl.the_loai_id, tl.the_loai_ten
    //         ORDER BY
    //             tong_luot_xem DESC
    //         LIMIT 5
    //     ";

    //     $obj = $this->connect->prepare($sql);
    //     $obj->setFetchMode(PDO::FETCH_OBJ);
    //     $obj->execute();

    //     return $obj->fetchAll();
    // }
}
