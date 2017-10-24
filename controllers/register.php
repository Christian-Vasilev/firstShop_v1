<?php
require_once '../classes/User.php';
require_once '../core/config.php';


if(isset($_POST['register'])){

    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $user = new User();

    $userExists = $user->userExists($db,$username);

    $user->registerUser($username,$password,$db,$userExists);

}

include_once '../views/Login.php';