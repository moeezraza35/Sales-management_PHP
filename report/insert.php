<?php
session_start();
if(!isset($_SESSION["User"])){
    header("location:/sales/login.html");
}
include "../db.php";
$my_db = new mysqli($host, $username, $password, $db_name);
$sql = "SELECT `sr` FROM `sales`";
$num = $my_db->query($sql)->num_rows;
$ini = $num + 1;
$sql = "SELECT * FROM `cart`;";
$cart = $my_db->query($sql);
if($cart->num_rows > 0){
    while ($row = $cart->fetch_assoc()) {
        $sql = "INSERT INTO `sales`(`sr`, `product`, `price`, `quantity`, `date`) VALUES ('$ini','{$row['product']}','{$row['price']}','{$row['quantity']}','".date("Y-m-d")."')";
        $ini += 1;
        $my_db->query($sql);
    }
    $sql = "DELETE FROM `cart`;";
    $my_db->query($sql);
}
header("location:/sales/");
?>