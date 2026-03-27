<?php
session_start();
require_once '../autoloader.php';
 
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['aangemeld' => false]);
    exit;
}
 
$activiteit_id = (int) ($_GET['activiteit_id'] ?? 0);
$user_id       = (int) $_SESSION['user_id'];
 
$conn       = Database::connect();
$aanmelding = new Aanmelding($conn);
 
echo json_encode(['aangemeld' => $aanmelding->isAangemeld($activiteit_id, $user_id)]);
?>