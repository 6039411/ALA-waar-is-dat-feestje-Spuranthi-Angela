
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
  <link rel="stylesheet" href="css/style.css">
  <script src="js/Home.js" defer></script>
</head>
<body>

<header>
  <h1>Activiteiten Kalender</h1>
  <nav>
    <a href="index.php">Home</a>
    <a href="#">Dashboard</a>
    <a href="inloggen.php">Inloggen</a>
    <a href="registreren.php">Registreren</a>
  </nav>
</header>

<article class="filters">
  <input type="text" placeholder="Zoek activiteit...">
  <select>
    <option>Alle types</option>
    <option>Binnen</option>
    <option>Buiten</option>
  </select>
  <select>
    <option>Alle statussen</option>
    <option>Gepland</option>
    <option>Geannuleerd</option>
    <option>Voltooid</option>
  </select>
  <button>Filter</button>
</article>

<article class="calendar">
<article class="calendar-header">
<button>&lt;</button>
<article class="month-selector">
<h2 id="current-month">Februari 2026</h2>
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
</article>

<!-- pop up form -->

<article id="day-popup" class="popup">
  <div class="popup-content">
    <span class="close-popup">&times;</span>
    <h2>Nieuwe Activiteit</h2>
    <p id="selected-date"></p>
    <form id="activity-form">
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

</body>
</html>
