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

class ChiTietDonHangModel extends Database
{

    public function ChiTietDonHang__Get_All()
    {
        $obj = $this->connect->prepare("SELECT * FROM chitietdonhang");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }
    public function ThongKe__Get_All()
    {
        $obj = $this->connect->prepare("SELECT dh.madon, dh.ngaythem, dh.tongdh, ctdh.tenkh, ctdh.sdt, sp.masp, sp.tensp, ctdh.soluong, ctdh.dongia, kc.tensize
            FROM donhang dh JOIN chitietdonhang ctdh ON dh.madon = ctdh.madon
                    JOIN sanpham sp ON ctdh.masp = sp.masp
                    JOIN kichco kc ON ctdh.masize = kc.idsize
            GROUP BY dh.madon;");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }
    public function ThongKe__Get_By_Madon($madon)
    {
        $obj = $this->connect->prepare("SELECT dh.madon, dh.ngaythem, dh.tongdh, ctdh.tenkh, ctdh.sdt, sp.masp, sp.tensp, ctdh.soluong, ctdh.dongia, kc.tensize
            FROM donhang dh JOIN chitietdonhang ctdh ON dh.madon = ctdh.madon
                    JOIN sanpham sp ON ctdh.masp = sp.masp
                    JOIN kichco kc ON ctdh.masize = kc.idsize
                    WHERE dh.madon = ?
            ORDER BY dh.madon;");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($madon));
        return $obj->fetchAll();
    }

    public function ChiTietDonHang__Add($madon, $masp, $soluong, $dongia, $masize, $tenkh, $sodienthoai)
    {
        $obj = $this->connect->prepare("INSERT INTO chitietdonhang(madon, masp, soluong, dongia, masize, tenkh, sdt) VALUES (?,?,?,?,?,?,?)");
        $obj->execute(array($madon, $masp, $soluong, $dongia, $masize, $tenkh, $sodienthoai));

        return $this->connect->lastInsertId();
    }


    public function ChiTietDonHang__Update($mactdh, $madon, $masp, $soluong, $dongia)
    {
        $obj = $this->connect->prepare("UPDATE chitietdonhang SET soluong=?, dongia=? WHERE mactdh =?");
        $obj->execute(array($soluong, $dongia, $madon, $masp, $mactdh));
        return $obj->rowCount();
    }

    public function ChiTietDonHang__Delete($mactdh)
    {
        $deleteStatement = $this->connect->prepare("DELETE FROM chitietdonhang WHERE mactdh=?");
        $deleteStatement->execute(array($mactdh));
        return $deleteStatement->rowCount();
    }
    public function ChiTietDonHang__Delete_By_Id_Dh($madon)
    {
        $deleteStatement = $this->connect->prepare("DELETE FROM chitietdonhang WHERE madon=?");
        $deleteStatement->execute(array($madon));
        return $deleteStatement->rowCount();
    }


    public function ChiTietDonHang__Get_By_Id($mactdh)
    {
        $obj = $this->connect->prepare("SELECT * FROM chitietdonhang WHERE mactdh=?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($mactdh));
        return $obj->fetch();
    }
    public function ChiTietDonHang__Sum_Tien_DH($madon)
    {
        $obj = $this->connect->prepare("SELECT SUM(soluong * dongia) as sum_tien FROM chitietdonhang WHERE madon=?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($madon));
        return $obj->fetch();
    }
    public function ChiTietDonHang__Get_By_Id_DH($madon)
    {
        $obj = $this->connect->prepare("SELECT *, (soluong*dongia) as tongcong FROM chitietdonhang WHERE madon=? ORDER BY mactdh DESC");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($madon));
        return $obj->fetchAll();
    }
    public function ChiTietDonHang__Get_By_Id_DH_info($madon)
    {
        $obj = $this->connect->prepare("SELECT tenkh, sdt FROM chitietdonhang WHERE madon=? ORDER BY mactdh DESC");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($madon));
        return $obj->fetch();
    }
    // tổng từ đầu đến giờ
    public function ChiThietDonHang__So_Mat_Hang()
    {
        $obj = $this->connect->prepare("SELECT sanpham.tensp
        FROM chitietdonhang 
        INNER JOIN sanpham ON chitietdonhang.masp = sanpham.masp 
        GROUP BY chitietdonhang.masp 
        ");
        $obj->execute();
        $results = $obj->fetchAll();
        return count($results);
    }
    public function ChiThietDonHang__Tong_Danh_Thu()
    {
        $obj = $this->connect->prepare("SELECT DATE(donhang.ngaythem) as ngay, 
        SUM(CASE WHEN donhang.trangthai = 1 THEN donhang.tongdh ELSE 0 END) AS tong_doanhthu 
        FROM donhang 
        ");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetch();
    }
    // ------------------------

    public function ChiThietDonHang__So_Mat_Hang_By_Date($startDate, $endDate)
    {
        $obj = $this->connect->prepare("SELECT sanpham.tensp, donhang.ngaythem
        FROM chitietdonhang 
        INNER JOIN sanpham ON chitietdonhang.masp = sanpham.masp 
        INNER JOIN donhang ON chitietdonhang.madon = donhang.madon
        WHERE donhang.ngaythem >= (?) AND donhang.ngaythem <= (?)     
        GROUP BY chitietdonhang.masp
        ");
        $obj->execute(array(date('Y-m-d 00:00:01', strtotime($startDate)), date('Y-m-d 23:59:59', strtotime($endDate))));
        $results = $obj->fetchAll();
        return count($results);
    }
    public function ChiThietDonHang__Tong_Danh_Thu_By_Date($startDate, $endDate)
    {
        $obj = $this->connect->prepare("SELECT DATE(donhang.ngaythem) as ngay, 
    SUM(CASE WHEN donhang.trangthai = 1 THEN donhang.tongdh ELSE 0 END) AS tong_doanhthu 
    FROM donhang WHERE donhang.ngaythem >= (?) AND donhang.ngaythem <= (?) 
    ");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array(date('Y-m-d 00:00:01', strtotime($startDate)), date('Y-m-d 23:59:59', strtotime($endDate))));
        return $obj->fetch();
    }

    public function ChiThietDonHang__Top_Ban_Chart()
    {
        $obj = $this->connect->prepare("SELECT sanpham.tensp, SUM(soluong) as sum_soluong FROM chitietdonhang INNER JOIN sanpham ON chitietdonhang.masp = sanpham.masp GROUP BY chitietdonhang.masp ORDER BY sum_soluong DESC LIMIT 10");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array());
        return $obj->fetchAll();
    }

    public function ChiThietDonHang__Doanh_Thu_Chart($startDate, $endDate)
    {
        $obj = $this->connect->prepare("SELECT DATE(donhang.ngaythem) as ngay, 
        SUM(CASE WHEN donhang.trangthai = 1 THEN donhang.tongdh ELSE 0 END) AS tong_doanhthu 
        FROM donhang 
        WHERE donhang.ngaythem >= (?) AND donhang.ngaythem <= (?) 
        GROUP BY DATE(donhang.ngaythem) 
        ORDER BY ngay;
        ");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array(date('Y-m-d 00:00:01', strtotime($startDate)), date('Y-m-d 23:59:59', strtotime($endDate))));
        return $obj->fetchAll();
    }
}
