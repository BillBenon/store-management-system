<?php
session_start();
if (!($_SESSION['userId'])) {
    header("location: login.php");
}
if (!($_SESSION['roleId'] == 3)) {
    header("location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
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
        function test_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        $prodName = test_input($_POST['prodName']);
        $prodBrand = test_input($_POST['prodBrand']);
        $Suptel = test_input($_POST['Suptel']);
        $supplier = test_input($_POST['supplier']);
        $register = $_SESSION['username'];

        if (empty($prodName) || empty($prodBrand) || empty($Suptel) || empty($supplier)) {
            $error = "*All fields are required!*";
        } else if (strlen($prodName) < 3 || strlen($prodName) > 100) {
            $error = "*Product Name must be 3 minimum and 100 maximum characters*";
        } else if (strlen($prodBrand) < 3 || strlen($prodBrand) > 100) {
            $error = "*Product Brand must be 3 minimum and 100 maximum characters*";
        } else if (!preg_match('/^(\+|(\+[1-9])?[0-9]*)*$/', $Suptel)) {
            $error = "*Invalid phone numbers*";
        } else if (strlen($supplier) < 4 || strlen($supplier) > 100) {
            $error = "*Supplier must be 4 minimum and 100 maximum characters*";
        } else {
            if (empty($error)) {
                $sql = "INSERT INTO stk_products(product_Name, brand, supplier_phone, supplier, register) VALUES ('$prodName', '$prodBrand', '$Suptel', '$supplier', '$register')";
                $insertQuery = mysqli_query($connection, $sql);
                if ($insertQuery) {
                    echo "<h3>Registered Product Successfully!</h3>";
                    header("location: display-products.php");
                } else {
                    echo "ERROR" . mysqli_connect_error();
                }
            }
        }
    }
    ?>
    <div class="all-content">
        <div class="main">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                <p><a href="javascript:history.go(-1)">Previous</a></p>
                <div class="form-header">
                    <h1>Add Product</h1>
                    <hr>
                    <p class="error"><?= $error; ?></p>
                </div>
                <div class="row">
                    <label for="prodName">Product Name</label>
                    <input type="text" name="prodName" id="prodName" placeholder="Enter Product Name" required>
                </div>
                <div class="row">
                    <label for="prodBrand">Product Brand</label>
                    <input type="text" name="prodBrand" id="prodBrand" placeholder="Enter Product Brand">
                </div>
                <div class="row">
                    <label for="Suptel">Supplier Phone</label>
                    <input type="tel" name="Suptel" id="Suptel" placeholder="Enter Telephone Number">
                </div>
                <div class="row">
                    <label for="supplier">Supplier</label>
                    <input type="text" name="supplier" id="supplier" placeholder="Enter Supplier Name">
                </div>
                <div class="submit">
                    <input type="submit" value="Register" name="submit">
                </div>
            </form>
        </div>
        <div class="footer">
            <p>Copyright 2021 &copy; Bill-Trezor | All rights reserved.</p>
        </div>
    </div>
</body>

</html>