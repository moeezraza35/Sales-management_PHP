<?php
session_start();
if(!isset($_SESSION["User"])){
    header("location:/sales/login.html");
}
include "../db.php";
$sql = "INSERT INTO `price`(`id`, `name`, `quantity`, `purchase_price`) VALUES ('" . $_POST["id"] . "','" . $_POST["name"] . "','" . $_POST["quantity"] . "','" . $_POST["purchase_price"] . "');";
$myDB = new mysqli($host, $username, $password, $db_name);
$myDB->query($sql);

header("location:/sales/pricing");
?>