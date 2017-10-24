<?php

/**
 * Created by PhpStorm.
 * User: Melomanchetoo
 * Date: 24.10.2017 г.
 * Time: 12:36
 */
class Money
{
    public static function updateMoney($db, $username, $price, $quantity){

        $userMoney = User::getUserInfo($db,$username);
        $money = $userMoney['money'] - ($price * $quantity);
        if($money < 0 ){
            echo 'ERROR: Not enough money'."<br/><br/>";
            die();
        }


        $stm = $db->prepare('UPDATE users SET MONEY = ? WHERE USERNAME = ?');
        $stm->execute(array($money, $username));

    }
}