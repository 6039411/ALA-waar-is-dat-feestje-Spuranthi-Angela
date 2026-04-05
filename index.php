<?php 
session_start();
session_destroy();
require_once 'autoloader.php';
$bericht_verstuurd = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['bericht'])) {
    $conn    = Database::connect();
    $bericht = new Bericht($conn);
    $tekst   = htmlspecialchars(trim($_POST['bericht']));
    $bericht_verstuurd = $bericht->opslaan($tekst, 1);
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Kalender voor het plannen en beheren van activiteiten.">
  <meta name="keywords" content="kalender, activiteiten, plannen, beheren, dashboard">
  <meta name="author" content="Angela Bansie">
  <title>Home pagina</title>
  <link rel="stylesheet" href="CSS/style.css">
  <script type="module" src="Js/Home.js"></script>
  <script type="module" src="Js/WeerApi.js"></script>
</head>
<body data-ingelogd="<?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>"></body>

<header>
  <h1>Activiteiten Kalender</h1>
  <nav>
    <a href="index.php">Home</a>
    <a href="inloggen.php">Inloggen</a>
    <a href="registreren.php">Registreren</a>
  </nav>
</header>

<article class="filters">
  <input type="text" id="search-input" placeholder="Zoek activiteit...">-
</article>

<article class="calendar">
  <article class="calendar-header">
    <button>&lt;</button>
    <article class="month-selector">
      <h2 id="current-month">Maart 2026</h2>
      <article class="month-dropdown" id="month-dropdown">
        <article data-month="Januari 2026">Januari 2026</article>
        <article data-month="Februari 2026">Februari 2026</article>
        <article data-month="Maart 2026">Maart 2026</article>
        <article data-month="April 2026">April 2026</article>
        <article data-month="Mei 2026">Mei 2026</article>
        <article data-month="Juni 2026">Juni 2026</article>
        <article data-month="Juli 2026">Juli 2026</article>
        <article data-month="Augustus 2026">Augustus 2026</article>
        <article data-month="September 2026">September 2026</article>
        <article data-month="Oktober 2026">Oktober 2026</article>
        <article data-month="November 2026">November 2026</article>
        <article data-month="December 2026">December 2026</article>
      </article>
    </article>
    <button>&gt;</button>
  </article>

  <article class="calendar-days">
    <article>Zo</article>
    <article>Ma</article>
    <article>Di</article>
    <article>Wo</article>
    <article>Do</article>
    <article>Vr</article>
    <article>Za</article>
  </article>

  <article class="calendar-grid">
    <article class="day">1</article>
    <article class="day">2</article>
    <article class="day">3</article>
    <article class="day">4</article>
    <article class="day">5</article>
    <article class="day">6</article>
    <article class="day">7</article>
    <article class="day">8</article>
    <article class="day">9</article>
    <article class="day">10</article>
    <article class="day">11</article>
    <article class="day">12</article>
    <article class="day">13</article>
    <article class="day">14</article>
    <article class="day">15</article>
    <article class="day">16</article>
    <article class="day">17</article>
    <article class="day">18</article>
    <article class="day">19</article>
    <article class="day">20</article>
    <article class="day">21</article>
    <article class="day">22</article>
    <article class="day">23</article>
    <article class="day">24</article>
    <article class="day">25</article>
    <article class="day">26</article>
    <article class="day">27</article>
    <article class="day">28</article>
    <article class="day">29</article>
    <article class="day">30</article>
  </article>
</article>

<article class="dashboard">
  <h2>Mijn Dashboard</h2>
  <article class="dashboard-cards">
    <article class="card">
      <h3>Mijn Activiteiten</h3>
      <p>Bekijk en beheer je aangemelde activiteiten.</p>
    </article>
    <article class="card">
      <h3>Activiteit Aanmaken</h3>
      <p>Organiseer een nieuwe activiteit.</p>
    </article>
    <article class="card">
      <h3>Notificaties</h3>
      <p>Bekijk recente meldingen.</p>
    </article>
  </article>
    <section id="dashboard">
    <div id="dashboard-list"></div>
  </section>
</article>

<article id="day-popup" class="popup">
  <div class="popup-content">
    <span class="close-popup">&times;</span>
    <h2>Nieuwe Activiteit</h2>
    <p id="selected-date"></p>

    <form id="activity-form" action="Actions/saveActiviteit.php" method="POST">

      <input type="hidden" name="activity-date" id="activity-date">

      <label for="activity-name">Naam activiteit</label>
      <input type="text" id="activity-name" name="activity-name" placeholder="Bijv. Voetbaltraining">

      <label for="activity-type">Type activiteit</label>
      <select id="activity-type" name="activity-type">
        <option value="">Kies type</option>
        <option>Binnen</option>
        <option>Buiten</option>
      </select>

      <label for="activity-time">Tijd</label>
      <input type="time" id="activity-time" name="activity-time">

      <label for="activity-status">Status</label>
      <select id="activity-status" name="activity-status">
        <option>Gepland</option>
        <option>Geannuleerd</option>
        <option>Voltooid</option>
      </select>

      <label for="activity-description">Beschrijving</label>
      <textarea id="activity-description" name="activity-description" placeholder="Beschrijving activiteit"></textarea>

      <button type="submit">Activiteit opslaan</button>
    </form>
  </div>
</article>

<article id="activity-detail" class="activity-detail">
  <div class="detail-content">
    <span id="close-detail">&times;</span>

    <h2 id="detail-name"></h2>
    <p><strong>Type:</strong> <span id="detail-type"></span></p>
    <p><strong>Datum:</strong> <span id="detail-date"></span></p>
    <p><strong>Tijd:</strong> <span id="detail-time"></span></p>
    <p><strong>Status:</strong> <span id="detail-status"></span></p>
    <p><strong>Beschrijving:</strong></p>
    <p id="detail-description"></p>

    <article id="weer" class="weer-card"></article>

    <span id="aanmelden">
    <button id="btn-aanmelden" class="knop-aanmelden">
        Aanmelden voor deze activiteit
    </button>
    <p id="aanmeld-bericht"></p>
    </span>

    <span id="uitnodiging">
    <input type="email" id="uitnodiging-email" name="uitnodiging-email" placeholder="emailadres@voorbeeld.nl">
    <button id="btn-uitnodiging">Uitnodiging sturen</button>
    <p id="uitnodiging-bericht"></p>
    </span>

  </div>
</article>

<article class="bericht-sectie">
  <h2>Stuur een bericht</h2>
  <?php if ($bericht_verstuurd): ?>
      <p class="bericht-ok">Bericht verstuurd!</p>
  <?php endif; ?>
  <form method="POST" action="">
      <input type="text" name="bericht" placeholder="Typ hier je bericht..." required>
      <button type="submit">Verstuur</button>
  </form>
</article>

</body>
</html>