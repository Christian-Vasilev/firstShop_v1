<?php
session_start();
require_once '../classes/User.php';
require_once '../core/config.php';

$sessionUsername = $_SESSION['username'];
$currentPassword = md5($_POST['current_password']);
$newPassword = md5($_POST['new_password']);
$repeatPassword = md5($_POST['repeat_password']);

$user = new User();
$user->changePassword($currentPassword, $newPassword, $repeatPassword, $sessionUsername, $db);

require_once '../views/change_password.php';