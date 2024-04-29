<?php
session_start();
if(!isset($_SESSION["User"])){
    header("location:/sales/login.html");
}
include "../db.php";
$myDB = new mysqli($host, $username, $password, $db_name);

$sql = "UPDATE `price` SET `name`='". $_POST["name"] ."',`quantity`='". $_POST["quantity"] ."',`purchase_price`='". $_POST["purchase_price"] ."' WHERE `id` = '". $_POST["id"] ."';";

$myDB->query($sql);
header("location:/sales/pricing");
?>