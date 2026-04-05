<?php

class Bericht implements BerichtInterface {

    private $conn;
    private $table_name = "bericht";

    public function __construct($db_conn) {
        $this->conn = $db_conn;
    }

    public function opslaan(string $tekst, int $user_id): bool {
        try {
            $sql  = "INSERT INTO " . $this->table_name . " (tekst, user_id) VALUES (?, ?)";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$tekst, $user_id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getAlle(): array {
        try {
            $sql  = "SELECT * FROM " . $this->table_name . " ORDER BY aangemaakt_op DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function verwijder(int $bericht_id): bool {
        try {
            $sql  = "DELETE FROM " . $this->table_name . " WHERE bericht_id = ?";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$bericht_id]);
        } catch (PDOException $e) {
            return false;
        }
    }

}