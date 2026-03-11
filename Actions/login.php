<?php
session_start(); 
include '../Includes/helper.php';
include '../Includes/util.php';
include '../Includes/database.php';
include '../Models/userConn.php';

$helper = new Helper();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = Helper::clean($_POST['username']);
    $password = Helper::clean($_POST['password']);

    if (!Helper::username($username)){
        $em = "Ongeldige gebruikersnaam.";
        util::redirect("../inloggen.php", "error", $em); 
    }else if (!Helper::password($password)){
        $em = "Ongeldige Wachtwoord.";
        util::redirect("../inloggen.php", "error", $em);
    }else{
        $db = new Database();   
        $conn = $db->connect();
        $user = new User($conn);
        $auth = $user->auth($username, $password);
        
        echo($auth);
        if($auth){
            $user_data = $user->getUser();
            $_SESSION['user_name'] = $user_data['user_name'];
            $_SESSION['user_id'] = $user_data['user_id'];
            $_SESSION['user_email'] = $user_data['user_email'];
            $_SESSION['user_full_name'] = $user_data['user_full_name'];

            $sm = "Ingelogd als gebruiker!";
            util::redirect("../index.php", "success", $sm);
        }else{
            echo($auth);
            $em = "Het wachtwoord of gebruikersnaam is fout.";
            util::redirect("../inloggen.php", "error", $em);
        }
    } 
}else{
    $em = "Er is een fout opgetreden.";
    util::redirect("../inloggen.php", $type, $em);
}

?>