<?php

class Products
{
    public function insertProduct($db, $productName, $productPrice, $productQuantity){

        if(empty($productName)){
            echo 'ERROR: The product name can not be empty!'."<br/><br/>";
            return;
        }

        if(!is_numeric($productPrice)){
            echo 'ERROR: The product price must contain only numbers!'."<br/><br/>";

            return;
        }if(!is_numeric($productQuantity)){
            echo 'ERROR: The product quantity must contain only numbers!'."<br/><br/>";

            return;
        }

        $stm = $db->prepare('INSERT INTO products (PRODUCT_NAME, PRODUCT_PRICE, PRODUCT_QUANTITY) values (:product, :price, :quantity)');

        $stm->bindParam('product',$productName);
        $stm->bindParam('price',$productPrice);
        $stm->bindParam('quantity',$productQuantity);

        echo 'Product with name '. $productName.' and price '. $productPrice.' was successfully entered';

        return $stm->execute();


    }

    public function buyProduct($db, $productName, $userId, $productQuantity){

        if(!is_numeric($productQuantity)){
            echo 'ERROR: The product quantity must contain only numbers!'."<br/><br/>";

            return;
        }
        if($productQuantity < 0){

            echo 'ERROR: Not enought quantity'."<br/><br/>";
            die();

        }

        $stm = $db->prepare('INSERT INTO inventory (PRODUCT_NAME, PRODUCT_QUANTITY, USER_ID) values (:product, :quantity, :userid)');

        $stm->bindParam('product',$productName);
        $stm->bindParam('quantity',$productQuantity);
        $stm->bindParam('userid',$userId);

        echo 'Product with name '. $productName.' and quantity '. $productQuantity.' was successfully added to your inventory'."<br/><br/>";

        return $stm->execute();






    }

    public function productExists($db, $productName){

        $stm = $db->prepare('SELECT * FROM products WHERE PRODUCT_NAME = ?');

        $stm->execute(array($productName));

        return $stm->rowCount();

    }

    public function productInfo($db, $productName){

        $stm = $db->prepare('SELECT * FROM products WHERE PRODUCT_NAME = ?');

        $stm->execute(array($productName));

        return $products = $stm->fetch(PDO::FETCH_ASSOC);

    }

    public function allProducts($db){

        $stm = $db->prepare('SELECT * FROM products');

        $stm->execute();

        return $products = $stm->fetchAll(PDO::FETCH_ASSOC);

    }

    Public function productUpdate($db, $productName, $productPrice, $productQuantity, $newQuantity, $type){
        if(empty($productName)){
            echo 'ERROR: The product name can not be empty!'."<br/><br/>";
            return;
        }

        if(!is_numeric($productPrice)){
            echo 'ERROR: The product price must contain only numbers!'."<br/><br/>";

            return;
        }if(!is_numeric($productQuantity)){
            echo 'ERROR: The product quantity must contain only numbers!'."<br/><br/>";

            return;
        }
        if($type = 'SELL'){
            if($newQuantity < 0) {
                echo 'Not enought quantity from this product. There are '.$productQuantity.' left';
                die();
            }else{
                $productQuantity = $newQuantity;
            }
        }else{
            $productQuantity += $newQuantity;
        }


        $stm = $db->prepare('UPDATE products SET PRODUCT_PRICE = :new_price, PRODUCT_QUANTITY = :new_quantity WHERE PRODUCT_NAME = :product');

        $stm->bindParam('new_price',$productPrice);
        $stm->bindParam('new_quantity', $productQuantity);
        $stm->bindParam('product', $productName);

        $stm->execute();

        echo 'Successfully updated the new quantity of the existing product '.$productName.''."<br/><br/>";



    }
}