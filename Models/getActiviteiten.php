<?php

require_once '../autoloader.php';

$conn = Database::connect();
$activiteit = new Activiteit($conn);

$data = $activiteit->getAll();

echo json_encode($data);