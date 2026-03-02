<?php
include '../Includes/validation.php';
include '../Includes/util.php';

$validation = new Validation();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = Validation::clean($_POST['fullname']);
    $username = Validation::clean($_POST['username']);
    $email = Validation::clean($_POST['email']);
    $password = Validation::clean($_POST['password']);
    $confirmPassword = Validation::clean($_POST['confirmPassword']);

    $data = "fname=".$fullname."&uname=".$username."&email=".$email;

    if (!Validation::name($fullname)){
        $em = "ongeldige naam.";
        util::redirect("../registreren.php", "error", $em, $data);
    }else if (!Validation::username($username)){
        $em = "ongeldige gebruikersnaam.";
        util::redirect("../registreren.php", "error", $em, $data); 
    }else if (!Validation::email($email)){
        $em = "ongeldig e-mailadres.";
        util::redirect("../registreren.php", "error", $em, $data);
    }else if (!Validation::password($password)){
        $em = "Ongeldige Wachtwoord.";
        util::redirect("../registreren.php", "error", $em, $data);
    }else if (!Validation::match($password, $confirmPassword)){
        $em = "Wachtwoorden komen niet overeen.";
        util::redirect("../registreren.php", "error", $em, $data);
    }
}else{
    $em = "Er is een fout opgetreden.";
    util::redirect("../registreren.php", $type, $em);
    header("Location: ?error=$em");

}

?>