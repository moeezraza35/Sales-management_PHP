<?php
include "db.php";
session_start();
if(!isset($_SESSION["User"])){
    header("location:/sales/login.html");
}else{
    $db_conn = new mysqli($host, $username, $password, $db_name);
    $item = $_GET["item"];

    $sql = "SELECT * FROM `cart` WHERE `id`='$item';";
    $record = $db_conn->query($sql);
    $row = $record->fetch_assoc();
    $quantity1 = $row["quantity"];
    $product = $row["product"];

    $sql = "SELECT * FROM `price` WHERE `id`='$product';";
    $record = $db_conn->query($sql);
    $row = $record->fetch_assoc();
    $qunatity = $row["quantity"];

    $quantity2 = $_POST["quantity"];
    $sql = "UPDATE `cart` SET `quantity`='$quantity2',`price`='".$_POST["price"]."' WHERE `id`='$item';";
    $db_conn->query($sql);

    $difference = $quantity1 - $quantity2;
    $quantity = $qunatity + $difference;
    $sql = "UPDATE `price` SET `quantity`='$quantity' WHERE `id` = '$product';";
    $db_conn->query($sql);

    header("location:/sales/");
}
?>