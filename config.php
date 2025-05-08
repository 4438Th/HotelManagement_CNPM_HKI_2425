<?php

class Database
{
    private static $instance = null; // Thể hiện duy nhất của lớp
    private $connection; // Kết nối database

    // Cấu hình database
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'QuanLyKhachSan';
    private $charset = 'utf8';

    // Constructor được đặt là private để ngăn tạo thể hiện bên ngoài
    private function __construct()
    {
        $dsn = "mysql:host={$this->host};dbname={$this->database};charset={$this->charset}";

        try {
            // Tạo kết nối PDO
            $this->connection = new PDO($dsn, $this->username, $this->password);
            // Thiết lập chế độ lỗi cho PDO
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Kết nối cơ sở dữ liệu thất bại: " . $e->getMessage());
        }
    }

    // Phương thức để lấy thể hiện duy nhất của lớp
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Lấy kết nối database
    public function getConnection()
    {
        return $this->connection;
    }

    // Ngăn chặn clone đối tượng
    private function __clone() {}

    // Ngăn chặn unserialize đối tượng
    private function __wakeup() {}
}
