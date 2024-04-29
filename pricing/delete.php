<?php
session_start();
if(!isset($_SESSION["User"])){
    header("location:/sales/login.html");
}
include "../db.php";
$myDB = new mysqli($host, $username, $password, $db_name);
$sql = "DELETE FROM `price` WHERE `id`=".$_GET["id"].';';
$myDB->query($sql);
header("location:/sales/pricing/");
?>