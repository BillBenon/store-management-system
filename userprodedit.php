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
    <title>Update Product</title>
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
        $prodId=$_GET['thisID'];
        $sql = "SELECT * FROM stk_products WHERE productId='$prodId'";
        $query = mysqli_query($connection, $sql);
        while($row=mysqli_fetch_assoc($query)) {
    ?>
    <div class="all-content">
        <div class="main">
            <form action="action.php?action=update-product" method="POST" enctype="multipart/form-data">
                <p><a href="javascript:history.go(-1)">Previous</a></p>
                <div class="form-header">
                    <h1>Add Product</h1>
                    <hr>
                    <p class="error"><?= $error; ?></p>
                </div>
                <input type="hidden" name="thisID" value="<?=$prodId?>">
                <div class="row">
                    <label for="prodName">Product Name</label>
                    <input type="text" name="prodName" id="prodName" placeholder="Enter Product Name" required value="<?=$row["product_Name"]?>">
                </div>
                <div class="row">
                    <label for="prodBrand">Product Brand</label>
                    <input type="text" name="prodBrand" id="prodBrand" placeholder="Enter Product Brand" required value="<?=$row["brand"]?>">
                </div>
                <div class="row">
                    <label for="Suptel">Supplier Phone</label>
                    <input type="tel" name="Suptel" id="Suptel" placeholder="Enter Telephone Number" pattern="(\+|(\+[1-9])?[0-9]*)" maxlength="15" minlength="10" required value="<?=$row["supplier_phone"]?>"  title="should be composed of + and numbers only with a maximum of 15 and minimum of 10">
                </div>
                <div class="row">
                    <label for="supplier">Supplier</label>
                    <input type="text" name="supplier" id="supplier" placeholder="Enter Supplier Name" required value="<?=$row["supplier"]?>">
                </div>
                <div class="submit">
                    <input type="submit" value="Register">
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