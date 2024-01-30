<?php
class Database
{

    public $connect;

    public function __construct()
    {
        $init = parse_ini_file("config.ini");
        $servername = $init["host"];
        $dbname = $init["dbname"];
        $username = $init["user"];
        $password = $init["pass"];
    
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $opt = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        );
    
        try {
            $this->connect = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password, $opt);
        } catch (PDOException $e) {
            echo "Lỗi kết nối cơ sở dữ liệu: " . $e->getMessage();
            exit();
        }
    }
    

    
}
?>