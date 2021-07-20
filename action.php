<?php

require('connection.php');

if($_GET["action"]=='deleteuser') {
    $userId = $_GET["thisID"];
    $sql = "DELETE FROM stk_users WHERE userId='$userId'";
    $deleteQuery = mysqli_query($connection, $sql);
    if(!$deleteQuery) {
        echo "ERROR " . mysqli_connect_error();
    } else {
        echo "Deleted User successfully!";
        header('location: display-users.php');
    }
} else if($_GET["action"]=="update-product") {
    $prodId = $_POST["thisID"];
    $prodName = $_POST['prodName'];
    $prodBrand = $_POST['prodBrand'];
    $Suptel = $_POST['Suptel'];
    $supplier = $_POST['supplier'];

    $sql = "UPDATE stk_products SET product_Name='$prodName',brand='$prodBrand',supplier_phone='$Suptel',supplier='$supplier' WHERE productId='$prodId'";
    $updateQuery = mysqli_query($connection, $sql);
    if($updateQuery) {
        echo "<h3>Updated Product Successfully!</h3>";
        header("location: display-products.php");
    }
    else {
        echo "ERROR" . mysqli_connect_error();
    }
} else if($_GET["action"]=="deleteprod") {
    $prodId = $_GET["thisID"];
    $sql = "DELETE FROM stk_products WHERE productId='$prodId'";
    $deleteQuery = mysqli_query($connection, $sql);
    if(!$deleteQuery) {
        echo "ERROR " . mysqli_connect_error();
    } else {
        echo "Deleted Product successfully!";
        header('location: display-products.php');
    }
} else if($_GET["action"]=="updateinventory") {
    $inventoryId = $_POST["inventoryId"];
    $prodQty = $_POST["prodQty"];
    $sql = "UPDATE stk_inventory SET quantity='$prodQty' WHERE inventory_id='$inventoryId'";
    $updateQuery = mysqli_query($connection, $sql);
    if($updateQuery) {
        echo "<h3>Updated Inventory Successfully!</h3>";
        header("location: display-stk_inventory.php");
    }
    else {
        echo "ERROR" . mysqli_connect_error();
    }
} else if($_GET["action"]=="deleteinventory") {
    $inventoryId = $_GET["thisID"];
    $sql = "DELETE FROM stk_inventory WHERE inventory_id='$inventoryId'";
    $deleteQuery = mysqli_query($connection, $sql);
    if(!$deleteQuery) {
        echo "ERROR " . mysqli_connect_error();
    } else {
        echo "Deleted Inventory successfully!";
        header('location: display-stk_inventory.php');
    }
} else if($_GET["action"]=="updatepurchase") {
    $outgoingId = $_POST["outgoingId"];
    $prodQty = $_POST["prodQty"];
    $sql = "UPDATE stk_outgoing SET quantity='$prodQty' WHERE outgoingId='$outgoingId'";
    $updateQuery = mysqli_query($connection, $sql);
    if($updateQuery) {
        echo "<h3>Updated Purchase Successfully!</h3>";
        header("location: display-stk_outgoing.php");
    }
    else {
        echo "ERROR" . mysqli_connect_error();
    }
} else if($_GET["action"]=="deletepurchase") {
    $outgoingId = $_GET["thisID"];
    $sql = "DELETE FROM stk_outgoing WHERE outgoingId='$outgoingId'";
    $deleteQuery = mysqli_query($connection, $sql);
    if(!$deleteQuery) {
        echo "ERROR " . mysqli_connect_error();
    } else {
        echo "Deleted Purchase successfully!";
        header('location: display-stk_outgoing.php');
    }
}
else {
    header("location: index.html");
}

?>