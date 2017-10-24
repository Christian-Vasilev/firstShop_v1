<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../styles/style.css"/>
    <title>Insert products</title>
    <center>
        <a href="../index.php" class="links">Back to home page</a><Br/><Br/>
        <div class="product">
            <h1>ADD PRODUCT</h1>
            <form action="../controllers/insert_product.php" method="post">
                <p>Product name:</p>
                <input type="text"  name="product_name" class="login"/>
                <p>Product price:</p>
                <input type="text"  name="product_price" class="login"/>
                <p>Product quantity:</p>
                <input type="text"  name="product_quantity" class="login"/><br/><br/>

                <input type="submit" value="Insert Product" name="insert" class="login"/>


            </form>
            <Br/>
        </div>
    </center>
</head>
<body>

</body>
</html>