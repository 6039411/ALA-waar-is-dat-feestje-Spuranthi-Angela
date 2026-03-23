<?php
include 'Includes/helper.php';

$fname = $uname = $email = "";
if (isset($_GET['fname'])){
    $fname = $_GET['fname'];
}
if (isset($_GET['uname'])){
    $uname = $_GET['uname'];
}
if (isset($_GET['email'])){
    $email = $_GET['email'];
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="description"
        content="Registreren voor een account op onze website. Vul je naam en wachtwoord in om een account aan te maken.">
    <meta name="keywords" content="registreren, account aanmaken, naam, wachtwoord">
    <meta name="author" content="Spuranthi Srirangam">
    <title>Inloggen</title>
    <link rel="stylesheet" type="text/css" href="CSS/style.css">
</head>

<body class="register">
    <article class="return_button">
        <a href="index.php">Ga weer terug als gast &#8617;</a>
    </article>
    <article class="wrapper">
        <article class="form-holder">
            <h2>Inloggen</h2>
            <form class="form" action="Actions/login.php" method="POST">
                <?php
                if (isset($_GET['error'])) { ?>
                    <p class="error"><?php echo Helper::clean($_GET['error']); ?></p>
                <?php } ?>

                <article class="form-group">
                    <input type="text" placeholder="gebruikersnaam" id="username" name="username">
                </article>

                <article class="form-group">
                    <input type="password" placeholder="wachtwoord" name="password">
                </article>

                <article class="form-group">
                    <button href="index.php" type="submit">Inloggen</button>
                </article>
                <article class="form-group">
                    <a href="registreren.php">Nog geen account? Registreer hier.</a>
                </article>
            </form>
        </article>
    </article>
</body>

</html>