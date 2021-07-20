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
    <title>Outgoing Products</title>
    <link rel="stylesheet" href="tables.css">
</head>

<body>
    <p><a href="index.php">Go to main page</a></p>
    <p><a href="display-products.php">Display Products</a></p>
    <?php
    $selectUserQuery = mysqli_query($connection, "SELECT ou.outgoingId,prod.product_Name,ou.quantity, ou.register FROM stk_outgoing ou INNER JOIN stk_products prod ON ou.productId=prod.productId");
    if (mysqli_num_rows($selectUserQuery) > 0) {
    ?>
    <div class="tabler">
        <table>
            <tr>
                <th>Purchase Id</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Register</th>
                <th>Update</th>
                <th>Delete</th>
            </tr>
            <?php
            while ($rows = mysqli_fetch_assoc($selectUserQuery)) { ?>
                <tr>
                    <td><?= $rows["outgoingId"] ?></td>
                    <td><?= $rows["product_Name"] ?></td>
                    <td><?= $rows["quantity"] ?></td>
                    <td><?= $rows["register"] ?></td>
                    <td><a href='purchaseedit.php?thisID=<?= $rows["outgoingId"] ?>'>Update</a></td>
                    <td><a href='action.php?action=deletepurchase&thisID=<?= $rows["outgoingId"] ?>'>Delete</a></td>
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
            $selectProdId = mysqli_query($connection, "SELECT productId FROM stk_outgoing GROUP BY productId");
            while ($rows = mysqli_fetch_assoc($selectProdId)) {
                $productId = $rows["productId"];
                $selectOutQuery = mysqli_query($connection, "SELECT prod.product_Name,SUM(ou.quantity) AS 'Total Quantity' FROM stk_products prod INNER JOIN stk_outgoing ou ON prod.productId=ou.productId WHERE ou.productId='$productId'");
                while ($row = mysqli_fetch_assoc($selectOutQuery)) { ?>
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
    <p>No products purchased yet!</p>
    <?php
    }
    ?>
</body>

</html>