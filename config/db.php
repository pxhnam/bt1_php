<?php
class Database
{
    // Thông tin kết nối cơ sở dữ liệu của bạn
    private $host = "localhost";
    private $db_name = "demo_store";
    private $username = "root";
    private $password = "";
    public $conn;

    // Phương thức kết nối đến cơ sở dữ liệu
    public function getConnection()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Lỗi kết nối cơ sở dữ liệu: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
