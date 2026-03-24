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

    // niew toegevoegd
    function getAll() {
        try {
            $sql = "SELECT * FROM " . $this->table_name;
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo $e->getMessage();
            return [];
        }
    }
}