<?php
session_start();
if (!($_SESSION['userId'])) {
    header("location: login.php");
}
require('connection.php');
if (!$connection) {
    echo "Some error occurred! We're trying to fix it soon.";
}
$selectUserQuery = mysqli_query($connection, "SELECT us.userId, us.firstName, us.lastName, us.telephone, us.gender, ctr.countryName as nationality, rl.roleName, us.username, us.email FROM countries ctr JOIN stk_users us ON ctr.countryId=us.nationality JOIN roles rl ON us.roleId=rl.roleId");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link rel="stylesheet" href="tables.css">
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <p><a href="index.php">Go to main page</a></p>
    <?php if (mysqli_num_rows($selectUserQuery) > 0) { ?>
        <form action="searchUser.php" method="POST">
            <div class="row">
                <input placeholder="Search User..." type="text" name="search_term" required>
            </div>
            <div class="row">
                <input type="submit" name="submit" value="Search">
            </div>
        </form>
        <div class="tabler">
            <table>
                <tr>
                    <th>User Id</th>
                    <th>FirstName</th>
                    <th>LastName</th>
                    <th>Telephone</th>
                    <th>Gender</th>
                    <th>Nationality</th>
                    <th>Role</th>
                    <th>Username</th>
                    <th>Email</th>
                    <?php
                    if ($_SESSION['roleId'] == 1) {
                    ?>
                        <th>Update</th>
                        <th>Delete</th>
                    <?php
                    }
                    ?>
                </tr>
                <?php
                while ($rows = mysqli_fetch_assoc($selectUserQuery)) { ?>
                    <tr>
                        <td><?= $rows["userId"] ?></td>
                        <td><?= $rows["firstName"] ?></td>
                        <td><?= $rows["lastName"] ?></td>
                        <td><?= $rows["telephone"] ?></td>
                        <td><?= $rows["gender"] ?></td>
                        <td><?= $rows["nationality"] ?></td>
                        <td><?= $rows["roleName"] ?></td>
                        <td><?= $rows["username"] ?></td>
                        <td><?= $rows["email"] ?></td>
                        <?php
                        if ($_SESSION['roleId'] == 1) {
                        ?>
                            <td><a href='useredit.php?thisID=<?= $rows["userId"] ?>'>Update</a></td>
                            <td><a href='action.php?action=deleteuser&thisID=<?= $rows["userId"] ?>'>Delete</a></td>
                        <?php
                        }
                        ?>
                    </tr>
                <?php
                }
                ?>
            </table>
        </div>
    <?php } else { ?>
        <p>No users registered!</p>
    <?php
    }
    ?>
</body>

</html>