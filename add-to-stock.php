<?php
session_start();
if (!($_SESSION['userId'])) {
    header("location: login.php");
}
if (empty($_GET["thisID"])) {
    header("location: display-products.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add to stock</title>
    <link rel="stylesheet" href="index.css">
    <style>
        .error {
            color: crimson;
            text-align: center;
            font-size: 15px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <?php
    require('connection.php');
    $error = "";
    if (isset($_POST['submit'])) {
        $prodId = $_GET["thisID"];
        $prodQty = $_POST["prodQty"];
        $register = $_SESSION['username'];
        if (!($prodQty > 0)) {
            $error = "*Product Quantity must be 1 and above";
        }
        if (empty($error)) {
            $sql = "INSERT INTO stk_inventory(productId, quantity, register) VALUES ('$prodId','$prodQty', '$register')";
            $insertQuery = mysqli_query($connection, $sql);
            if ($insertQuery) {
                echo "<h3>Registered Purchase Successfully!</h3>";
                header("location: display-stk_inventory.php");
            } else {
                echo "ERROR" . mysqli_connect_error();
            }
        }
    }
    ?>
    <div class="all-content">
        <div class="main">
            <form action="add-to-stock.php?thisID=<?= $_GET["thisID"]; ?>" method="POST" enctype="multipart/form-data">
                <p><a href="javascript:history.go(-1)">Previous</a></p>
                <div class="form-header">
                    <h1>Add to stock</h1>
                    <hr>
                    <p class="error"><?= $error; ?></p>
                </div>
                <div class="row">
                    <label for="prodQty">Quantity</label>
                    <input type="number" name="prodQty" id="prodQty" placeholder="Enter Product Quantity" required>
                </div>
                <div class="submit">
                    <input type="submit" value="Add to stock" name="submit">
                </div>
            </form>
        </div>
        <div class="footer">
            <p>Copyright 2021 &copy; Bill-Trezor | All rights reserved.</p>
        </div>
    </div>
</body>

</html>