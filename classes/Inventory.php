<?php

class Inventory
{
    public static function inventoryBool($db,$userId,$productName){
        $stm = $db->prepare('SELECT inventory.product_name, inventory.product_quantity
                           FROM inventory
                           INNER JOIN users ON inventory.user_id = users.id WHERE inventory.user_id = ? AND inventory.product_name = ?;');
        $stm->execute(array($userId,$productName));

        return $stm->rowCount();


    }
    public static function userInventory($db,$userId){
        $stm = $db->prepare('SELECT inventory.product_name, inventory.product_quantity
                           FROM inventory
                           INNER JOIN users ON inventory.user_id = users.id WHERE inventory.user_id = ?;');

        $stm->execute(array($userId));

        return $stm->fetchAll(PDO::FETCH_ASSOC);



    }
    public static function userUpdateInventory($db,$productQuantity,$productName,$userId){
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