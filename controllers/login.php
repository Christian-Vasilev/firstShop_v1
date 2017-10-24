<?php
session_start();
require_once '../classes/User.php';
require_once '../core/config.php';

if(!isset($_SESSION['user_id'])) {
    if ($_POST['login']) {

        $username = $_POST['username'];

        $password = md5($_POST['password']);

        $user = new User();

        $user->userLogin($username,$password,$db);

    }
}else{
    echo 'You are already logged in';
}

include_once '../views/Login.php';