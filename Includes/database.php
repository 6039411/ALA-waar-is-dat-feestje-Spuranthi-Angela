<?php
class Database {
    private $host = "localhost";
    private $db_name = "waar_is_dat_feestje";
    private $uName = "root";
    private $pass = "";
    private $conn;

    private static $instance;

    private function __construct() {
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name}",
                $this->uName,
                $this->pass
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch(PDOException $e) {
            die("Connection error: " . $e->getMessage());
        }
    }

    private static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public static function connect() {
        return self::getInstance()->conn;
    }
}

?>