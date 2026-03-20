<?php

require_once '../autoloader.php';

$conn = Database::connect();
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

?>