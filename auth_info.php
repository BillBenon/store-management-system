<?php
session_start();
if (!($_SESSION['userId'])) {
    header("location: login.php");
}
if ($_SESSION['roleId'] != 1) {
    header("location: index.php");
}
require('connection.php');
if (!$connection) {
    echo "Some error occurred! We're trying to fix it soon.";
}
$selectUserQuery = mysqli_query($connection, "SELECT us.username, au.mac_address, au.ip_address, au.OS, au.Browser, au.loggedin_at FROM stk_users us INNER JOIN auth_user_info au ON us.userId=au.userId");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Authentication info</title>
    <link rel="stylesheet" href="tables.css">
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <p><a href="index.php">Go to main page</a></p>
    <?php if (mysqli_num_rows($selectUserQuery) > 0) { ?>
        <div class="tabler">
            <table>
                <tr>
                    <th>Username</th>
                    <th>MAC Address</th>
                    <th>IP Address</th>
                    <th>Operating System</th>
                    <th>Browser</th>
                    <th>Logged in at</th>
                </tr>
                <?php
                while ($rows = mysqli_fetch_assoc($selectUserQuery)) { ?>
                    <tr>
                        <td><?= $rows["username"] ?></td>
                        <td><?= $rows["mac_address"] ?></td>
                        <td><?= $rows["ip_address"] ?></td>
                        <td><?= $rows["OS"] ?></td>
                        <td><?= $rows["Browser"] ?></td>
                        <td><?=$rows["loggedin_at"]?></td>
                    </tr>
                <?php
                }
                ?>
            </table>
        </div>
    <?php } else { ?>
        <p>No users authenticated yet!</p>
    <?php
    }
    ?>
</body>

</html>