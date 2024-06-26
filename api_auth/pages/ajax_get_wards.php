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

$database = new Database();
$pdo = $database->connect;

// Chuẩn bị và thực thi truy vấn SQL để lấy dữ liệu từ bảng 'province'
try {
    $district_id = $_GET['district_id'];
    $sql = "SELECT * FROM wards WHERE district_id = {$district_id}";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Lỗi truy vấn: " . $e->getMessage();
    die();

}    

    // echo $district_id;

    $data[0] = [
        'id' => null,
        'name' => 'Chọn một xã/phường'
    ];

    foreach ($results as $row) {
        $data[] = [
            'id' => $row['wards_id'],
            'name' => $row['name']
        ];
    }
    echo json_encode($data);
?>