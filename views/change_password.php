<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update password</title>
    <link rel="stylesheet" href="../styles/style.css"/>
</head>
<body>
<div class="box">
    <h2>Change Password</h2>

    <form action="../controllers/change_password.php" method="post">
        <p>Current password:</p>
        <input type="text"  name="current_password" class="login"/>
        <p>New password:</p>
        <input type="password"  name="new_password" class="login"/>
        <p>Repeat new password:</p>
        <input type="password"  name="repeat_password" class="login"/><br/><br/>

        <input type="submit" value="Change password" name="change" class="login"/>


    </form>
    <Br/>
</div>
</body>
</html>