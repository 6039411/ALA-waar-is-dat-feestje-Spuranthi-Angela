<?php

class Helper {
    static function clean($str){
        $str = trim($str);
        $str = stripslashes($str);
        $str = htmlspecialchars($str);
        return $str;
    }

    static function name($str){
        $name_regex = "/^[a-zA-Z ]*$/";
        if (preg_match($name_regex,$str)) {
            return true;
        } else {
            return false;
        }
    }
    static function username($str){
        $username_regex = "/^[a-zA-Z0-9_]+$/";
        if (preg_match($username_regex,$str)) {
            return true;
        } else {
            return false;
        }
    }
    static function email($str){
        $email_regex = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
        if (preg_match($email_regex,$str)) {
            return true;
        } else {
            return false;
        }
    }
    static function password($str){
        // min 4 karakters, 1 kleine en hoofdletter, speciaal teken en cijfertje like bijvoorbeeld Test@pass1
        $password_regex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{4,}$/";
        if (preg_match($password_regex,$str)) {
            return true;
        } else {
            return false;
        }
    }
    static function match($password, $confirmPassword){
        if ($password === $confirmPassword) {
            return true;
        } else {
            return false;
        }
    }
}   
?>
