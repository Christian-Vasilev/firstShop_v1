<?php
session_start();
spl_autoload_register(function ($class_name) {
    require_once '../classes/'. $class_name . '.php';
});
require_once '../core/config.php';

if(!isset($_SESSION['username'])){
    echo 'Plase login in order to insert products';
}

if(isset($_POST['submit'])){
    $productName = $_POST['product_name'];
    $productPrice = $_POST['product_price'];
    $productOrder = $_POST['amount'];
    if(empty($productOrder) || !is_numeric($productOrder)){
        echo 'ERROR: Wrong product input';

    }else{
        $productQuantity = $_POST['product_quantity'];
        $sessionId = $_SESSION['user_id'];
        $totalQuant = '';
        $products = new Products();
        $user = new User();

        $productInfo = $products->productInfo($db, $productName);

        $countQuantity = $user->specificProduct($db,$sessionId,$productName);
        foreach($countQuantity as $product){

        $totalQuant = $product['product_quantity'] + $productOrder;

        }

        $quantity = $productInfo['product_quantity'] - $productOrder;


        Money::updateMoney($db,$_SESSION['username'],$productPrice, $productOrder);

        if(Inventory::inventoryBool($db,$sessionId,$productName) > 0){

            Inventory::userUpdateInventory($db,$totalQuant,$productName,$sessionId);

        }else{

            $products->buyProduct($db, $productName,$sessionId,$productOrder);

        }
        $products->productUpdate($db,$productName, $productPrice, $productQuantity, $quantity, 'sell');
    }
}


require_once '../views/Login.php';