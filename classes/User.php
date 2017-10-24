<?php

class User
{

    public function changePassword($currentPassword, $newPassword, $repeatPassword, $sessionUsername, $db)
    {

        if (!isset($_SESSION['username'])) {
            echo 'In order to change your password, please log in!';
            die();
        }

        if (isset($_POST['change'])) {

            if (empty($currentPassword)) {
                echo 'You must enter your current password' . "<br/>";
            } elseif (empty($newPassword)) {
                echo 'You must enter new password' . "<br/>";
            } elseif (empty($repeatPassword)) {
                echo 'You must repeat your new password' . "<br/>";
            }

            $db_stm = $db->prepare('SELECT PASSWORD FROM users WHERE USERNAME = ?');

            $db_stm->execute(array($sessionUsername));

            while ($row = $db_stm->fetch(PDO::FETCH_ASSOC)) {

                if ($row['PASSWORD'] != $currentPassword) {

                    echo 'The password you have entered does not match your current password.' . "<br/>";

                } elseif ($newPassword != $repeatPassword) {

                    echo 'The repeated password does not match your new password!' . "<br/>";

                } elseif ($newPassword === $repeatPassword AND $row['PASSWORD'] === $currentPassword) {

                    $dbUpdate = $db->prepare('UPDATE users SET PASSWORD = :new_password WHERE USERNAME = :current_user');
                    $dbUpdate->bindParam('new_password', $newPassword);
                    $dbUpdate->bindParam('current_user', $sessionUsername);

                    $dbUpdate->execute();

                    echo 'Your password has been updated successfully.' . "<br/>";
                    echo 'You will be logged out in 2 seconds to apply the new settings';
                    header("refresh:3;url=logout.php");


                }


            }
        }
    }
    public function userLogin($username, $password, $db){

        $db_stm = $db->prepare('SELECT ID,USERNAME, PASSWORD FROM users WHERE USERNAME = ?');
        $db_stm->execute(Array($username));

        while ($getData = $db_stm->fetch(PDO::FETCH_ASSOC)) {


            if ($username === $getData['USERNAME'] AND $password === $getData['PASSWORD']) {

                $_SESSION['user_id'] = $getData['ID'];
                $_SESSION['username'] = $getData['USERNAME'];
                header("refresh:3;url=../index.php");
                echo 'Welcome, ' . $_SESSION['username'] . "<br/>" . 'You will be redirected in 3 seconds.' . "<br/>";
                echo 'If the redirection does not work please click the link bellow' . "<br/>";
                echo "<a href='../index.php'>LINK</a>";
            } else {
                echo 'Password or username does not match';
            }
        }
    }
    public function userExists($db, $username){

        $stm = $db->prepare('SELECT username FROM users WHERE username = ?');
        $stm->execute(array($username));

        return $stm->rowCount();


    }
    public function registerUser($username, $password, $db, $userExists){
        if($userExists > 0){
            echo 'User with that username already exists';
            return;
        }
        if(empty($username)){

            echo 'Username can not be left blank.';

        }elseif(empty($password)){

            echo 'Password can not be left blank.';

        }

            $db_stm = $db->prepare('INSERT INTO users (USERNAME,PASSWORD)
                                VALUES (:username,:password)');


            $db_stm->bindParam('username', $username);
            $db_stm->bindParam('password', $password);

            echo 'You are successfully registered';

            return $db_stm->execute();

        }
    public static function getUserInfo($db, $sessionUsername){

        $stm = $db->prepare('SELECT * FROM users WHERE username = ?');
        $stm->execute(array($sessionUsername));
        return $userInfo = $stm->fetch(PDO::FETCH_ASSOC);


    }
    public function updateMoney($db, $username, $price, $quantity){

        $userMoney = $this->getUserInfo($db,$username);
        $money = $userMoney['money'] - ($price * $quantity);
        if($money < 0 ){
            echo 'ERROR: Not enough money'."<br/><br/>";
            die();
        }


        $stm = $db->prepare('UPDATE users SET MONEY = ? WHERE USERNAME = ?');
        $stm->execute(array($money, $username));

    }

    public function specificProduct($db,$userId, $productName){
        $stm = $db->prepare('SELECT inventory.product_name, inventory.product_quantity
                           FROM inventory
                           INNER JOIN users ON inventory.user_id = users.id WHERE inventory.user_id = ? AND inventory.product_name = ?;');
        $stm->execute(array($userId,$productName));


        return $stm->fetchAll(PDO::FETCH_ASSOC);


    }
    public function inventoryBool($db,$userId,$productName){
        $stm = $db->prepare('SELECT inventory.product_name, inventory.product_quantity
                           FROM inventory
                           INNER JOIN users ON inventory.user_id = users.id WHERE inventory.user_id = ? AND inventory.product_name = ?;');
        $stm->execute(array($userId,$productName));

        return $stm->rowCount();


    }
    public function userInventory($db,$userId){
        $stm = $db->prepare('SELECT inventory.product_name, inventory.product_quantity
                           FROM inventory
                           INNER JOIN users ON inventory.user_id = users.id WHERE inventory.user_id = ?;');

        $stm->execute(array($userId));

        return $stm->fetchAll(PDO::FETCH_ASSOC);



    }
    public function userUpdateInventory($db,$productQuantity,$productName,$userId){
        $stm = $db->prepare('UPDATE inventory
                            INNER JOIN users 
                            ON inventory.user_id = users.id 
                            SET inventory.product_quantity = :quantity
                            WHERE inventory.user_id = :userid
                            AND inventory.product_name = :product');

        $stm->bindParam('quantity', $productQuantity);
        $stm->bindParam('userid', $userId);
        $stm->bindParam('product', $productName);
        echo 'Successfully added the new quantity of '.$productName.' in your inventory'."<br/><br/>";
        return $stm->execute();


    }
}