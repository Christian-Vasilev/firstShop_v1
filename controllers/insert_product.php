<?php
session_start();
spl_autoload_register(function ($class_name) {
    require_once '../classes/'. $class_name . '.php';
});
require_once '../core/config.php';

if(!isset($_SESSION['username'])){
    echo 'Plase login in order to insert products';
}

if(isset($_POST['insert'])){
    $productName = $_POST['product_name'];
    $productPrice = $_POST['product_price'];
    $productQuantity = $_POST['product_quantity'];

    $products = new Products();

    $productExists = $products->productExists($db, $productName);

    $productInfo = $products->productInfo($db, $productName);

    if($productExists > 0){

        $products->productUpdate($db, $productName, $productPrice, $productQuantity,$productInfo['product_quantity'], 'buy');


    }else{

        $products->insertProduct($db, $productName, $productPrice, $productQuantity);

    }
}




require_once '../views/product.php';