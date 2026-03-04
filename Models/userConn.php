<?php
class User {
    private $table_name;
    private $conn;

    private $user_id;
    private $user_name;
    private $user_email;
    private $user_password;


    function __construct($db_conn) {
        $this->conn = $db_conn;
        $this->table_name = "user";
    }

    function insert($data) {
        try {
            $sql = 'INSERT INTO ' . $this->table_name . ' (user_name, user_password, user_full_name, user_email) VALUES (?, ?, ?, ?)';
            $stmt = $this->conn->prepare($sql);
            $res = $stmt->execute($data);
            return $res;
        } catch(PDOException $e) {
            return 0; 
        }
    }
    
}
?>