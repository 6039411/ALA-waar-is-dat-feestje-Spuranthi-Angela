<?php
require_once __DIR__ . "/../Includes/database.php";

$database = new Database();
$conn = $database->connect();

// Check of het formulier is verzonden
if(isset($_POST['activity-name'])) {

    $naam = $_POST['activity-name'];
    $type = $_POST['activity-type'];
    $tijd = $_POST['activity-time'];
    $beschrijving = $_POST['activity-description'];
    $datum = $_POST['activity-date'];

    // Let op hoofdletters zoals in de database
    $sql = "INSERT INTO activiteiten (Naam, Type, Tijd, Beschrijving, Datum)
            VALUES (:naam, :type, :tijd, :beschrijving, :datum)";

    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':naam', $naam);
    $stmt->bindParam(':type', $type);
    $stmt->bindParam(':tijd', $tijd);
    $stmt->bindParam(':beschrijving', $beschrijving);
    $stmt->bindParam(':datum', $datum);

    $stmt->execute();

    echo "Activiteit opgeslagen!";
} else {
    echo "Formulier niet verzonden!";
}