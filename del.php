<?php
session_start();
if(!isset($_SESSION["User"])){
    header("location:/sales/");
}else{
    include "db.php";
    $db_conn = new mysqli($host, $username, $password, $db_name);
    $item = $_GET["item"];

    $sql = "SELECT * FROM `cart` WHERE `id`='$item'";
    $record = $db_conn->query($sql);
    $row = $record->fetch_assoc();
    $quantity1 = $row["quantity"];
    $product = $row["product"];

    $sql = "DELETE FROM `cart` WHERE `id`='$item';";
    $db_conn->query($sql);

    $sql = "SELECT * FROM `price` WHERE `id`='$product';";
    $record = $db_conn->query($sql);
    $row = $record->fetch_assoc();
    $quantity2 = $row["quantity"];

    $quantity = $quantity1 + $quantity2;
    $sql = "UPDATE `price` SET `quantity`='$quantity' WHERE `id`='$product';";
    $db_conn->query($sql);

    header("location:/sales/");
}
?>