<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "blabla";
}else{
    $em = "Er is een fout opgetreden.";
    header("Location: ../registreren.php?error=$em");
    exit();
}

?>