<?php
session_start();
if (!($_SESSION['userId'])) {
    header("location: login.php");
}
if (empty($_GET["thisID"])) {
    header("location: display-stk_outgoing.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Purchase</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <?php
        require('connection.php');
        $error = "";
        $outgoingId = $_GET["thisID"];
        $sql = "SELECT quantity FROM stk_outgoing WHERE outgoingId='$outgoingId'";
        $query = mysqli_query($connection, $sql);
        while($row=mysqli_fetch_assoc($query)) {

    ?>
    <div class="all-content">
        <div class="main">
        <form action="action.php?action=updatepurchase" method="POST" enctype="multipart/form-data">
                <p><a href="display-products.php">Previous</a></p>
                <div class="form-header">
                    <h1>Update Purchase</h1>
                    <hr>
                    <p class="error"><?= $error; ?></p>
                </div>
                <input type="hidden" name="outgoingId" id="outgoingId" value="<?=$_GET["thisID"]?>">
                <div class="row">
                    <label for="prodQty">Quantity</label>
                    <input type="number" name="prodQty" id="prodQty" placeholder="Enter Product Quantity" required value="<?=$row["quantity"]?>">
                </div>
                <div class="submit">
                    <input type="submit" value="Update Purchase">
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