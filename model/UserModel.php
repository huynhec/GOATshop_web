<?PHP 
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
class   UserModel extends Database
{

    public function User__Get_All()
    {
        $obj = $this->connect->prepare("SELECT users.mauser, users.username, users.trangthai, users.tenhienthi, users.phanquyen
                                        FROM users 
                                        LEFT JOIN admin ON users.mauser = admin.mauser 
                                        LEFT JOIN nhanvien ON users.mauser = nhanvien.mauser 
                                        LEFT JOIN khachhang ON users.mauser = khachhang.mauser ");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute();
        return $obj->fetchAll();
    }

    public function User__Add($tenhienthi, $username, $password, $phanquyen, $trangthai)
    {
        // Thêm người dùng vào bảng users
        $obj = $this->connect->prepare("INSERT INTO users (tenhienthi, username, password, phanquyen, trangthai)
                                        VALUES (?, ?, ?, ?, ?)");
        $obj->execute(array($tenhienthi, $username, $password, $phanquyen, $trangthai));
    
        // Lấy mauser vừa được thêm
        $mauser = $this->connect->lastInsertId();
    
        // Thêm thông tin vào bảng nhanvien hoặc khachhang tùy thuộc vào giá trị của $phanquyen
        if ($phanquyen == 1) {
            $stmt = $this->connect->prepare("INSERT INTO nhanvien (mauser) VALUES (?)");
            $stmt->execute(array($mauser));
        } elseif ($phanquyen == 2) {
            $stmt = $this->connect->prepare("INSERT INTO khachhang (mauser) VALUES (?)");
            $stmt->execute(array($mauser));
        }
        return $obj->rowCount();
    }
    

    public function User__Update($tenhienthi, $username, $password, $phanquyen, $trangthai, $mauser)
    {
        $obj = $this->connect->prepare("UPDATE users SET tenhienthi = ?, username = ?, password = ?, phanquyen = ?, trangthai = ? WHERE mauser = ? ");
        $obj->execute(array( $tenhienthi, $username, $password, $phanquyen, $trangthai, $mauser));
        return $obj->rowCount();
    }

    // public function User__Delete($mauser)
    // {
    //     $obj = $this->connect->prepare("DELETE FROM users WHERE mauser =?");
    //     $obj->execute(array($mauser));
    //     return $obj->rowCount();
    // }
    public function User__Delete($mauser)
{
    // Lấy phân quyền của người dùng cần xoá
    $query = "SELECT phanquyen FROM users WHERE mauser = ?";
    $stmt = $this->connect->prepare($query);
    $stmt->execute([$mauser]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Kiểm tra phân quyền và xoá tương ứng
    if ($result) {
        $phanquyen = $result['phanquyen'];

        if ($phanquyen == 1) {
            // Xoá nhân viên
            $this->deleteNhanVien($mauser);
        } elseif ($phanquyen == 2) {
            // Xoá khách hàng
            $this->deleteKhachHang($mauser);
        }

        // Xoá người dùng
        $query = "DELETE FROM users WHERE mauser = ?";
        $stmt = $this->connect->prepare($query);
        $stmt->execute([$mauser]);

        return $stmt->rowCount();
    }

    return 0;
}

private function deleteNhanVien($mauser)
{
    // Xoá nhân viên dựa trên mauser
    $query = "DELETE FROM nhanvien WHERE mauser = ?";
    $stmt = $this->connect->prepare($query);
    $stmt->execute([$mauser]);
}

private function deleteKhachHang($mauser)
{
    // Xoá khách hàng dựa trên mauser
    $query = "DELETE FROM khachhang WHERE mauser = ?";
    $stmt = $this->connect->prepare($query);
    $stmt->execute([$mauser]);
}


    public function User__Get_By_Id($mauser)
    {
        $obj = $this->connect->prepare("SELECT * FROM users WHERE mauser = ?");
        $obj->setFetchMode(PDO::FETCH_OBJ);
        $obj->execute(array($mauser));
        return $obj->fetch();
    }


}


?>