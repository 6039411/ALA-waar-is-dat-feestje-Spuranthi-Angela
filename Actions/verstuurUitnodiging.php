<?php
session_start();
require_once '../autoloader.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['succes' => false, 'bericht' => 'Je moet ingelogd zijn.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['succes' => false, 'bericht' => 'Ongeldig verzoek.']);
    exit;
}

$activiteit_id = (int) $_POST['activiteit_id'];
$email         = trim($_POST['email']);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['succes' => false, 'bericht' => 'Ongeldig e-mailadres.']);
    exit;
}

$conn             = Database::connect();
$activiteit_model = new Activiteit($conn);
$activiteit_data  = $activiteit_model->getById($activiteit_id);

if (!$activiteit_data) {
    echo json_encode(['succes' => false, 'bericht' => 'Activiteit niet gevonden.']);
    exit;
}

$uitnodiging = new Uitnodiging($conn);

if ($uitnodiging->verstuur($activiteit_id, $email, $activiteit_data)) {
    echo json_encode(['succes' => true, 'bericht' => "Uitnodiging verstuurd naar {$email}!"]);
} else {
    echo json_encode(['succes' => false, 'bericht' => 'Versturen mislukt. (ligt wss aan mailHog of php.ini']);
}
?>