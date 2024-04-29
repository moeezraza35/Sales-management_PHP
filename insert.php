<?php
session_start();
if(!isset($_SESSION["User"])){
    header("location:/sales/login.html");
}
include "db.php";
$my_db = new mysqli($host, $username, $password, $db_name);

$sql = "SELECT * FROM `cart`";
$result = $my_db->query($sql);
$idno = $result->num_rows+1;

$sql = "INSERT INTO `cart` (`id`, `product`, `quantity`, `price`) VALUES ('".$idno."','".$_POST["id"]."','".$_POST["add"]."','".$_POST["selling"]."');";

$my_db->query($sql);

$sql = "UPDATE `price` SET `quantity`= `quantity` - '".$_POST["add"]."' WHERE `id`='".$_POST["id"]."';";
$my_db->query($sql);
header("location:/sales/");
?>