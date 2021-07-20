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
    <title>Incoming Products</title>
    <link rel="stylesheet" href="tables.css">
</head>

<body>
    <p><a href="index.php">Go to main page</a></p>
    <p><a href="display-products.php">Display Products</a></p>
    <?php
    $selectQuery = mysqli_query($connection, "SELECT inv.inventory_id,inv.productId,prod.product_Name,inv.quantity, inv.register FROM stk_inventory inv INNER JOIN stk_products prod ON inv.productId=prod.productId");
    if (mysqli_num_rows($selectQuery) > 0) {
    ?>
        <div class="tabler">
            <table>
                <tr>
                    <th>Inventory Id</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Register</th>
                    <th>Update</th>
                    <th>Delete</th>
                </tr>
                <?php
                while ($rows = mysqli_fetch_assoc($selectQuery)) { ?>
                    <tr>
                        <td><?= $rows["inventory_id"] ?></td>
                        <td><?= $rows["product_Name"] ?></td>
                        <td><?= $rows["quantity"] ?></td>
                        <td><?= $rows["register"] ?></td>
                        <td><a href='inventoryedit.php?thisID=<?= $rows["inventory_id"] ?>'>Update</a></td>
                        <td><a href='action.php?action=deleteinventory&thisID=<?= $rows["inventory_id"] ?>'>Delete</a></td>
                    </tr>
                <?php
                }
                ?>
            </table>
        </div>
        <div class="tabler">
            <table>
                <tr>
                    <th>Product Name</th>
                    <th>Total Quantity</th>
                </tr>
                <?php
                $selectProdId = mysqli_query($connection, "SELECT productId FROM stk_inventory GROUP BY productId");
                while ($rows = mysqli_fetch_assoc($selectProdId)) {
                    $productId = $rows["productId"];
                    $selectInvQuery = mysqli_query($connection, "SELECT prod.product_Name,SUM(inv.quantity) AS 'Total Quantity' FROM stk_products prod INNER JOIN stk_inventory inv ON prod.productId=inv.productId WHERE inv.productId='$productId'");
                    while ($row = mysqli_fetch_assoc($selectInvQuery)) { ?>
                        <tr>
                            <td><?= $row["product_Name"] ?></td>
                            <td><?= $row["Total Quantity"] ?></td>
                        </tr>
                <?php
                    }
                }
                ?>
            </table>
        </div>
    <?php
    } else {
    ?>
        <p>No products added to stock yet!</p>
    <?php
    }
    ?>
</body>

</html>