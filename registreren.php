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
    <title>Registreren</title>
    <link rel="stylesheet" type="text/css" href="CSS/style.css">
</head>

<body>
    <article class="wrapper">
        <article class="form-holder">
            <h2>Registreren</h2>
            <form class="form" action="Actions/signup.php" method="POST">
                <?php
                if (isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
                <?php } ?>
                <article class="form-group">
                    <input type="text" placeholder="volledige naam" name="fullname" >
                </article>

                <article class="form-group">
                    <input type="text" placeholder="gebruikersnaam" id="username" name="username" >
                </article>

                <article class="form-group">
                    <input type="email" placeholder="e-mailadres" id="email" name="email" >
                </article>

                <article class="form-group">
                    <input type="password" placeholder="wachtwoord" name="password">
                </article>

                <article class="form-group">
                    <input type="password" placeholder="bevestig wachtwoord" name="confirmPassword" >
                </article>

                <article class="form-group">
                    <button type="submit">Registreren</button>
                </article>
                <article class="form-group">
                    <a href="inloggen.php">Log hier in.</a>
                </article>
            </form>
        </article>
    </article>
</body>

</html>