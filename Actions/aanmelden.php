<?php
session_start();
require_once '../autoloader.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['succes' => false, 'bericht' => 'Je moet ingelogd zijn om je aan te melden.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['succes' => false, 'bericht' => 'Ongeldig verzoek.']);
    exit;
}

$activiteit_id = (int) $_POST['activiteit_id'];
$actie         = $_POST['actie'];
$user_id       = (int) $_SESSION['user_id'];

$conn       = Database::connect();
$aanmelding = new Aanmelding($conn);

if ($actie === 'aanmelden') {
    if ($aanmelding->aanmelden($activiteit_id, $user_id)) {
        echo json_encode(['succes' => true, 'bericht' => 'Aangemeld!']);
    } else {
        echo json_encode(['succes' => false, 'bericht' => 'Je hebt jezelf al aangemeld voor deze activiteit']);
    }
} elseif ($actie === 'afmelden') {
    if ($aanmelding->afmelden($activiteit_id, $user_id)) {
        echo json_encode(['succes' => true, 'bericht' => 'Je bent afgemeld.']);
    } else {
        echo json_encode(['succes' => false, 'bericht' => 'Afmelden mislukt.']);
    }
} else {
    echo json_encode(['succes' => false, 'bericht' => 'Geen idee wat er aan de hand is man']);
}
?>