<?php
session_start();
if (!($_SESSION['userId'])) {
    header("location: login.php");
}
require('connection.php');
if (!$connection) {
    echo "Some error occurred! We're trying to fix it soon.";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="tables.css">
</head>

<body>
    <p><a href="index.php">Go to main page</a></p>

    <?php

    $selectUserQuery = mysqli_query($connection, "SELECT * FROM stk_products");

    if (mysqli_num_rows($selectUserQuery) > 0) { ?>
        <div class="tabler">
            <table>
                <tr>
                    <th>Product Id</th>
                    <th>Product Name</th>
                    <th>Product Brand</th>
                    <th>Supplier Phone</th>
                    <th>Supplier</th>
                    <th>Register</th>
                    <th>Add to stock</th>
                    <th>Purchase</th>
                    <?php
                    if ($_SESSION['roleId'] == 3) {
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
                        <td><?= $rows["productId"] ?></td>
                        <td><?= $rows["product_Name"] ?></td>
                        <td><?= $rows["brand"] ?></td>
                        <td><?= $rows["supplier_phone"] ?></td>
                        <td><?= $rows["supplier"] ?></td>
                        <td><?= $rows["register"] ?></td>
                        <td><a href='add-to-stock.php?thisID=<?= $rows["productId"] ?>'>Add to stock</a></td>
                        <td><a href='purchase.php?thisID=<?= $rows["productId"] ?>'>Purchase</a></td>
                        <?php
                        if ($_SESSION['roleId'] == 3) {
                        ?>
                            <td><a href='userprodedit.php?thisID=<?= $rows["productId"] ?>'>Update</a></td>
                            <td><a href='action.php?action=deleteprod&thisID=<?= $rows["productId"] ?>'>Delete</a></td>
                        <?php
                        }
                        ?>
                    </tr>
                <?php
                }
            } else { ?>
                <p>No Products registered yet!</p>
            <?php }
            ?>
            </table>
        </div>
        <p><a href="display-stk_inventory.php">Display Inventories</a></p>
        <p><a href="display-stk_outgoing.php">Display Outgoings</a></p>
</body>

</html>