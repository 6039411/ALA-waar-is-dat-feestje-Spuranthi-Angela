<?php
require_once '../autoloader.php';

$helper = new Helper();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = Helper::clean($_POST['fullname']);
    $username = Helper::clean($_POST['username']);
    $email = Helper::clean($_POST['email']);
    $password = Helper::clean($_POST['password']);
    $confirmPassword = Helper::clean($_POST['confirmPassword']);

    $data = "fname=".$fullname."&uname=".$username."&email=".$email;

    if (!Helper::name($fullname)){
        $em = "ongeldige naam.";
        util::redirect("../registreren.php", "error", $em, $data);
    }else if (!Helper::username($username)){
        $em = "ongeldige gebruikersnaam.";
        util::redirect("../registreren.php", "error", $em, $data); 
    }else if (!Helper::email($email)){
        $em = "ongeldig e-mailadres.";
        util::redirect("../registreren.php", "error", $em, $data);
    }else if (!Helper::password($password)){
        $em = "Ongeldige Wachtwoord.";
        util::redirect("../registreren.php", "error", $em, $data);
    }else if (!Helper::match($password, $confirmPassword)){
        $em = "Wachtwoorden komen niet overeen.";
        util::redirect("../registreren.php", "error", $em, $data);
    } else{
        $user = new User($conn);

        $pass = password_hash($password, PASSWORD_DEFAULT);
        $user_data = [$username, $pass, $fullname, $email];
        $res = $user->insert($user_data);
        if($res){
            $sm = "Gelukt! U kunt nu inloggen met uw account.";
            util::redirect("../registreren.php", "success", $sm);
        }else{
            $em = "Er is een error gekomen...";
            util::redirect("../registreren.php", "error", $em, $data);
        }
    }
    }else{
    $em = "Er is een fout opgetreden.";
    util::redirect("../registreren.php", $type, $em);
    header("Location: ?error=$em");

}

?>