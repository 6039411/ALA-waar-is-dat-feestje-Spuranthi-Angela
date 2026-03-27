<?php 
require_once '../autoloader.php';

class RegularUser extends User {
    public function auth($user_name, $user_password) {
        return parent:: auth($user_name, $user_password);
    }
}

?>