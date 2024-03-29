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

class SanPhamModel extends Database
{

    public function SanPham__Get_All($trangthai)
    {
        if ($trangthai != -1) {
            $obj = $this->connect->prepare("SELECT * FROM sanpham");
        } else {
            $obj = $this->connect->prepare("SELECT * FROM sanpham ");
        }
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }

    public function SanPham__Get_By_Id($masp)
    {
        $obj = $this->connect->prepare("SELECT * FROM sanpham WHERE masp = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($masp));
        return $obj->fetch();
    }
    public function SanPham__Get_By_IdLoai($maloai)
    {
        $obj = $this->connect->prepare("SELECT * FROM sanpham WHERE maloai = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($maloai));
        return $obj->fetch();
    }



    public function SanPham__Get_Top_Updated($limit = 6)
    {
        $sql = "SELECT * FROM sanpham
        WHERE trangthai=?
        GROUP BY sanpham.masp
        ORDER BY ngaythem DESC
        LIMIT $limit";

        $obj = $this->connect->prepare($sql);
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array(1));
        return $obj->fetchAll();
    }

    public function SanPham__Add($tensp, $mota, $ngaythem, $trangthai, $luotmua, $math, $maloai)
    {
        $obj = $this->connect->prepare("INSERT INTO sanpham(tensp, mota, ngaythem, trangthai, luotmua, math, maloai) VALUES (?,?,?,?,?,?,?)");
        $obj->execute(array($tensp, $mota, $ngaythem, $trangthai, $luotmua, $math, $maloai));
        return $this->connect->lastInsertId();
    }


    public function SanPham__Update($masp, $tensp, $mota, $ngaythem, $trangthai, $luotmua, $math, $maloai)
    {
        $obj = $this->connect->prepare("UPDATE sanpham SET tensp=?, mota=?, ngaythem=?, trangthai=?, luotmua=?, math=?, maloai=? WHERE masp=?");
        $obj->execute(array($tensp, $mota, $ngaythem, $trangthai, $luotmua, $math, $maloai, $masp));
        return $obj->rowCount();
    }

    public function SanPham__Delete($masp)
    {
        $obj = $this->connect->prepare("DELETE FROM sanpham WHERE masp = ?");
        $obj->execute(array($masp));

        return $obj->rowCount();
    }

    public function SanPham__Get_All_Paged($page_number)
    {
        // Số lượng truyện trên mỗi trang
        $items_per_page = 14;

        // Tính toán giá trị bắt đầu và kết thúc cho phân trang
        $page_start = ($page_number - 1) * $items_per_page;
        $page_end = $items_per_page;

        // Chuẩn bị và thực hiện truy vấn
        $obj = $this->connect->prepare(
            "SELECT *
            FROM sanpham
            WHERE trangthai = 1
            GROUP BY masp
            LIMIT :page_start, :page_end"
        );

        $obj->bindParam(':page_start', $page_start, PDO::PARAM_INT);
        $obj->bindParam(':page_end', $page_end, PDO::PARAM_INT);

        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }

    public function SanPham__Update_Luot_Mua($masp, $luotmua)
    {
        $obj = $this->connect->prepare("UPDATE sanpham SET luotmua=? WHERE masp=?");
        $obj->execute(array($luotmua, $masp));
        return $obj->rowCount();
    }

    public function SanPham__Get_Top_Random($limit = 6)
    {
        $sql = "SELECT * FROM sanpham
        WHERE trangthai=?
        ORDER BY RAND()
        LIMIT $limit";

        $obj = $this->connect->prepare($sql);
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array(1));
        return $obj->fetchAll();
    }

    public function SanPham__Get_Top_Same($math,  $masp)
    {
        $sql = "SELECT * FROM sanpham INNER JOIN thuonghieu ON sanpham.math = thuonghieu.math WHERE thuonghieu.math =? AND sanpham.masp !=? AND sanpham.trangthai=1
        ORDER BY RAND()
        LIMIT 6";

        $obj = $this->connect->prepare($sql);
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($math, $masp));
        return $obj->fetchAll();
    }

    public function SanPham__Get_Top_Sale()
    {
        $sql = "SELECT * FROM sanpham WHERE trangthai=? ORDER BY luotmua DESC  LIMIT 3";
        $obj = $this->connect->prepare($sql);
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array(1));
        return $obj->fetchAll();
    }

    public function SanPham__Get_By_Th_Paged($page_number, $math)
    {
        // Số lượng sp trên mỗi trang
        $items_per_page = 12;

        // Tính toán giá trị bắt đầu và kết thúc cho phân trang
        $page_start = ($page_number - 1) * $items_per_page;
        $page_end = $items_per_page;

        // Chuẩn bị và thực hiện truy vấn
        $obj = $this->connect->prepare(
            "SELECT *
            FROM sanpham
            WHERE trangthai = 1 AND math = $math
            GROUP BY masp
            LIMIT :page_start, :page_end"
        );

        $obj->bindParam(':page_start', $page_start, PDO::PARAM_INT);
        $obj->bindParam(':page_end', $page_end, PDO::PARAM_INT);

        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }

    public function SanPham__Get_Ten_Sp_Paged($page_number, $tensp)
    {
        // Số lượng sp trên mỗi trang
        $items_per_page = 12;

        // Tính toán giá trị bắt đầu và kết thúc cho phân trang
        $page_start = ($page_number - 1) * $items_per_page;
        $page_end = $items_per_page;

        // Chuẩn bị và thực hiện truy vấn
        $obj = $this->connect->prepare(
            "SELECT *
            FROM sanpham
            WHERE trangthai = 1 AND tensp LIKE '%$tensp%'
            GROUP BY masp
            LIMIT :page_start, :page_end"
        );

        $obj->bindParam(':page_start', $page_start, PDO::PARAM_INT);
        $obj->bindParam(':page_end', $page_end, PDO::PARAM_INT);

        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }

    public function SanPham__Get_By_Loai_Paged($page_number, $maloai)
    {
        // Số lượng sp trên mỗi trang
        $items_per_page = 12;

        // Tính toán giá trị bắt đầu và kết thúc cho phân trang
        $page_start = ($page_number - 1) * $items_per_page;
        $page_end = $items_per_page;

        // Chuẩn bị và thực hiện truy vấn
        $obj = $this->connect->prepare(
            "SELECT *
            FROM sanpham
            WHERE trangthai = 1 AND maloai = $maloai
            GROUP BY masp
            LIMIT :page_start, :page_end"
        );

        $obj->bindParam(':page_start', $page_start, PDO::PARAM_INT);
        $obj->bindParam(':page_end', $page_end, PDO::PARAM_INT);

        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }
}
