<?php


require_once __DIR__ . "/../Includes/database.php";

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




$database = new Database();
$conn = $database->connect();
$activiteit = new Activiteit($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $naam        = $_POST['activity-name'];
    $type        = $_POST['activity-type'];
    $tijd        = $_POST['activity-time'];
    $beschrijving = $_POST['activity-description'];
    $datum       = $_POST['activity-date'];

    $data = [$naam, $type, $tijd, $beschrijving, $datum];

    if ($activiteit->insert($data)) {
        echo "succes";
    } else {
        echo "mislukt";
    }
}