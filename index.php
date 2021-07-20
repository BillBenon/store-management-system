<?php
session_start();
if (!($_SESSION['userId'])) {
    header("location: login.php");
}
require('connection.php');
$userId = $_SESSION['userId'];
$selectUserQuery = mysqli_query($connection, "SELECT us.firstName, us.lastName, rl.roleName as role FROM stk_users us INNER JOIN roles rl ON us.roleId=rl.roleId WHERE userId='" . $userId . "'");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Management System</title>
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <div class="all-content">
        <div class="main-body">
            <div class="all-links">
                <h1>USER MANAGEMENT SYSTEM</h1>
                <hr>
                <p style="text-align: center;"> Welcome
                    <?php
                    while ($rows = mysqli_fetch_assoc($selectUserQuery)) {
                        $_SESSION['roleName'] = $rows["role"];
                        echo $rows["role"] . " " . $rows["firstName"] . " " . $rows["lastName"];
                    }
                    ?>
                </p>
                <ul>
                    <?php
                    if ($_SESSION['roleId'] == 1) {
                    ?>
                        <li><a href="create-user.php">Create User Account</a></li>
                    <?php
                    }
                    ?>
                    <li><a href="display-users.php">Display Users</a></li>
                    <?php
                    if ($_SESSION['roleId'] == 3) {
                    ?>
                        <li><a href="create-product.php">Create Product</a></li>
                    <?php
                    }
                    ?>
                    <li><a href="display-products.php">Display Products</a></li>
                    <?php
                    if ($_SESSION['roleId'] == 1) {
                    ?>
                    <li><a href="auth_info.php">User Authentication info</a></li>
                    <?php
                    }
                    ?>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
        <div class="footer">
            <p>Copyright 2021 &copy; Bill-Trezor | All rights reserved.</p>
        </div>
    </div>
</body>

</html>