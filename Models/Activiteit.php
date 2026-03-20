<?php

class Activiteit {

    private $conn;
    private $table_name = "activiteit";

    function __construct($db_conn) {
        $this->conn = $db_conn;
    }

    function insert($data) {
        try {
            $sql = "INSERT INTO " . $this->table_name . " 
                    (Naam, Type, Tijd, Beschrijving, Datum)
                    VALUES (?, ?, ?, ?, ?)";

            $stmt = $this->conn->prepare($sql);
            return $stmt->execute($data);

        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}

