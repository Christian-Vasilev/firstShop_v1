<?php
session_start();
spl_autoload_register(function ($class_name) {
    require_once '../classes/'. $class_name . '.php';
});

require_once '../core/config.php';
$user = new User();


$count = 0;
?>
<html>
<head>
    <title>FIrst login system</title>
    <link rel="stylesheet" href="../styles/style.css"/>

</head>
<body>
<?php if(isset($_SESSION['user_id']) == TRUE): $userInventory = $user->userInventory($db,$_SESSION['user_id']); $userInfo = User::getUserInfo($db,$_SESSION['username']);?>

    <img src="../images/Logo.png"/><br/>
    You are logged in as, <?= $_SESSION['username'] ?>!<br/> You have <b class="money"><?= number_format($userInfo['money']); ?></b> leva<br/><br/>
    <a href="../index.php" class="links">Home</a> |  <a href="../views/inventory.php" class="links">My Inventory</a> |  <a href="../views/product.html" class="links">Add products</a> |  <a href="../views/change_password.html" class="links">Change password</a> | <a href="../controllers/logout.php" class="links">Logout</a>
    <br/><br/>
    <!--- SHOP START --->
    <center>
        <table width="950px">
            <tr class="table">
                <td class="table" width="5%">#</td>
                <td class="table" width="45%">Name</td>
                <td class="table" width="10%">Quantity</td>
                <td class="table" width="30%">Operation</td>
            </tr>

            <?php if(empty($userInventory)): ?>
                <tr class="table">
                    <td class="table" colspan="5">There are no products in your inventory. Click <a href="../index.php" class="links">HERE</a> to add some products</td>
                </tr>
            <?php endif; ?>

            <?php foreach($userInventory as $user): $count++ ?>
                <tr class="table">
                    <td class="table" width="5%"><?= $count ?></td>
                    <td class="table" width="60%"><?= $user['product_name'] ?></td>
                    <td class="table" width="10%"><?= number_format($user['product_quantity']) ?></td>
                    <?php if($user['product_quantity'] == 0): ?>

                        <td class="table" width="10%"><p class="stock">OUT OF STOCK</p></p></td>

                    <?php else: ?>

                        <td class="table" width="15%">
                            <form action="../controllers/buy_product.php" method="post">
                                <input type="hidden"  name="product_price" value="<?= $user['product_price'] ?>"/>
                                <input type="hidden"  name="product_quantity" value="<?= $user['product_quantity'] ?>"/>
                                <input type="hidden"  name="product_name" value="<?= $user['product_name'] ?>"/>
                                <input type="text" class="order" name="amount"/>
                                <input type="submit" class="order" name="submit" value="SELL"/>
                            </form>

                        </td>

                    <?php endif; ?>

                </tr>
            <?php endforeach; ?>
        </table>
    </center>

    <!--- SHOP END --->


<?php else: ?>
    <table style="text-align:center;">
        <tr>
            <td>
                <div class="box">
                    <h1>Login</h1>

                    <form action="../controllers/login.php" method="post">
                        <p>Username:</p>
                        <input type="text"  name="username" class="login"/>
                        <p>Password:</p>
                        <input type="password"  name="password" class="login"/><br/><br/>

                        <input type="submit" value="Login" name="login" class="login"/>


                    </form>
                    <Br/>
                </div>
            </td>
            <td>
                <div class="box">
                    <h1>Register</h1>

                    <form action="../controllers/register.php" method="post">
                        <p>Username:</p>
                        <input type="text"  name="username" class="login"/>

                        <p>Password:</p>
                        <input type="password"  name="password" class="login"/>
                        <br/><br/>

                        <input type="submit" value="Register" name="register" class="login"/>

                    </form>
                    <Br/>
                </div>
            </td>
        </tr>
    </table>
<?php endif; ?>

</body>
</html>

