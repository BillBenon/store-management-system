<?php

$host = "localhost";
$user = "root";
$db_password = ""; 
$database = "STORE_MANAGEMENT_SYSTEM";

$connection = mysqli_connect($host, $user, $db_password, $database);

if(!$connection){
    echo "ERROR: FAILED TO CONNECT TO DATABASE.";
}

?>