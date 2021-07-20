<?php
session_start();
if (!($_SESSION['userId'])) {
    header("location: login.php");
}
if (empty($_GET["thisID"])) {
    header("location: display-stk_inventory.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update inventory</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <?php
        require('connection.php');
        $error = "";
        $inventoryId = $_GET["thisID"];
        $sql = "SELECT quantity FROM stk_inventory WHERE inventory_id='$inventoryId'";
        $query = mysqli_query($connection, $sql);
        while($row=mysqli_fetch_assoc($query)) {

    ?>
    <div class="all-content">
        <div class="main">
        <form action="action.php?action=updateinventory" method="POST" enctype="multipart/form-data">
                <p><a href="display-stk_inventory.php">Previous</a></p>
                <div class="form-header">
                    <h1>Update inventory</h1>
                    <hr>
                    <p class="error"><?= $error; ?></p>
                </div>
                <input type="hidden" name="inventoryId" id="inventoryId" value="<?=$_GET["thisID"]?>">
                <div class="row">
                    <label for="prodQty">Quantity</label>
                    <input type="number" name="prodQty" id="prodQty" placeholder="Enter Product Quantity" required value="<?=$row["quantity"]?>">
                </div>
                <div class="submit">
                    <input type="submit" value="Update inventory">
                </div>
            </form>
        </div>
        <div class="footer">
            <p>Copyright 2021 &copy; Bill-Trezor | All rights reserved.</p>
        </div>
    </div>
    <?php
        }
    ?>
</body>
</html>