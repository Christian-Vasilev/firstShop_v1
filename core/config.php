<?php

$dbConfig = [

    'mysql_host' => 'localhost',
    'mysql_table' => 'login',
    'mysql_user' => 'root',
    'mysql_password' => ''

];


$db = new PDO("mysql:host=$dbConfig[mysql_host];dbname=$dbConfig[mysql_table]", $dbConfig['mysql_user'], $dbConfig['mysql_password'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
