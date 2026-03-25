<?php
class Aanmelding {

    private $conn;
    private $table_name = "aanmelding";

    public function __construct($db_conn) {
        $this->conn = $db_conn;
    }

    public function aanmelden($activiteit_id, $user_id) {
        if ($this->isAangemeld($activiteit_id, $user_id)) {
            return false;
        }
        try {
            $sql  = "INSERT INTO " . $this->table_name . " (activiteit_id, user_id) VALUES (?, ?)";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$activiteit_id, $user_id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function afmelden($activiteit_id, $user_id) {
        try {
            $sql  = "DELETE FROM " . $this->table_name . " WHERE activiteit_id = ? AND user_id = ?";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([$activiteit_id, $user_id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function isAangemeld($activiteit_id, $user_id) {
        try {
            $sql  = "SELECT aanmelding_id FROM " . $this->table_name . " WHERE activiteit_id = ? AND user_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$activiteit_id, $user_id]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getAanmeldingenVoorActiviteit($activiteit_id) {
        try {
            $sql = "SELECT u.user_full_name, u.user_email, a.aangemeld_op
                    FROM " . $this->table_name . " a
                    JOIN user u ON a.user_id = u.user_id
                    WHERE a.activiteit_id = ?
                    ORDER BY a.aangemeld_op ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$activiteit_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
}
?>