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
            if ($stmt->execute($data)) {
                return $this->conn->lastInsertId();
            }
            return false;

        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    function getAll() {
        try {
            $sql  = "SELECT * FROM " . $this->table_name;
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo $e->getMessage();
            return [];
        }
    }

    function getById($id) {
        try {
            $sql = "SELECT id, Naam AS naam, Datum AS datum, Tijd AS tijd, Beschrijving AS beschrijving
                    FROM " . $this->table_name . "
                    WHERE id = ?";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return false;
        }
    }
}
?>