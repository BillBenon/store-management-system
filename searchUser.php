<?php
session_start();
if (!($_SESSION['userId'])) {
    header("location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Search Results</title>
    <link rel="stylesheet" href="tables.css">
</head>

<body>
    <?php
    include "connection.php";
    $term = $_POST["search_term"];
    ?>
    <p><a href="display-users.php">Display all Users</a></p>
    <?php
    $selectUserQuery = mysqli_query($connection, "SELECT us.userId, us.firstName, us.lastName, us.telephone, us.gender, ctr.countryName as nationality, us.username, us.email FROM stk_users us INNER JOIN countries ctr ON us.nationality=ctr.countryId WHERE us.username LIKE '%$term%' OR us.username LIKE '%$term' OR us.username LIKE '$term%'");
    if (empty($rows = mysqli_fetch_assoc($selectUserQuery))) {
        echo "<p>No user found!</p>";
    } else {
    ?>
        <div class="tabler">
            <table>
                <tr>
                    <th>User Id</th>
                    <th>FirstName</th>
                    <th>LastName</th>
                    <th>Telephone</th>
                    <th>Gender</th>
                    <th>Nationality</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Update</th>
                    <th>Delete</th>
                </tr>
                <tr>
                    <td><?= $rows["userId"] ?></td>
                    <td><?= $rows["firstName"] ?></td>
                    <td><?= $rows["lastName"] ?></td>
                    <td><?= $rows["telephone"] ?></td>
                    <td><?= $rows["gender"] ?></td>
                    <td><?= $rows["nationality"] ?></td>
                    <td><?= $rows["username"] ?></td>
                    <td><?= $rows["email"] ?></td>
                    <td><a href='useredit.php?thisID=<?= $rows["userId"] ?>'>Update</a></td>
                    <td><a href='action.php?action=deleteuser&thisID=<?= $rows["userId"] ?>'>Delete</a></td>
                </tr>
            <?php
        }
            ?>
            </table>
        </div>
</body>

</html>