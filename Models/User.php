<?php
class User {
    private $table_name = "user";
    private $conn;

    private $user_id;
    private $user_name;
    private $user_email;
    private $user_full_name;

    public function __construct() {
        $this->conn = Database::connect();
    }

    function insert($data) {
        try {
            $sql = 'INSERT INTO ' . $this->table_name . ' 
                    (user_name, user_password, user_full_name, user_email) 
                    VALUES (?, ?, ?, ?)';

            $stmt = $this->conn->prepare($sql);
            return $stmt->execute($data);

        } catch(PDOException $e) {
            return 0; 
        }
    }
    
    function auth($user_name, $user_password) {
        try {
            $sql = 'SELECT * FROM ' . $this->table_name . ' WHERE user_name = ?';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$user_name]);

            if ($stmt->rowCount() === 1) {
                $user = $stmt->fetch();

                if (password_verify($user_password, $user['user_password'])) {
                    $this->user_id = $user['user_id'];
                    $this->user_name = $user['user_name'];
                    $this->user_email = $user['user_email'];
                    $this->user_full_name = $user['user_full_name'];
                    return 1;
                }
            }
            return 0;

        } catch(PDOException $e) {
            return 0; 
        }
    }

    function getUser(){
        return [
            'user_id' => $this->user_id,
            'user_name' => $this->user_name,
            'user_email' => $this->user_email,
            'user_full_name' => $this->user_full_name
        ];
    }
}

?>