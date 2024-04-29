<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        *{
            margin: 0%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body{
            padding: 10px;
        }
        h1{
            font-weight: lighter;
            margin: 20px 0%;
        }
        main{
            position: relative;
            width: 90%;
            overflow: hidden;
            margin: auto;
        }
        table{
            width: 100%;
            border-collapse: collapse;
        }
        td, th{
            padding: 10px;
        }
        td:nth-child(even), th:nth-child(even){
            background-color: rgb(235, 235, 235);
        }
        tr{
            border-bottom: 1px solid rgb(220, 220, 220);
            border-top: 1px solid rgb(220, 220, 220);
        }
    </style>
</head>
<body>
    <main class="container">
        <h2>
            Sales
        </h2>
        <table class="table">
            <tr>
                <th>Sr no.</th>
                <th>ID</th>
                <th>Name</th>
                <th>In Stock</th>
                <th>Purchase Price</th>
                <th>Quantity</th>
                <th>Selling Price</th>
                <th>Total Price</th>
            </tr>
<?php
session_start();
if(!isset($_SESSION["User"])){
    header("location:/sales/login.html");
}
include "db.php";
$my_db = new mysqli($host, $username, $password, $db_name);

$sql = "SELECT * FROM `cart`;";
$cart = $my_db->query($sql);
$cost = 0;
$total_price = 0;
if($cart->num_rows > 0){
    while($row = $cart->fetch_assoc()){
        echo "<tr>".
                "<td>".$row["id"]."</td>".
                "<td>".$row["product"]."</td>";
        $sql = "SELECT * FROM `price`;";
        $price = $my_db->query($sql);
        if($price->num_rows > 0){
            while($item = $price->fetch_assoc()){
                if($item["id"] === $row["product"]){
                    echo "<td>".$item["name"]."</td>".
                    "<td>".$item["quantity"]."</td>";
                    $cost = $item["purchase_price"];
                }
            }
        }
        echo "<td>".$cost."</td>".
        "<td>".$row["quantity"]."</td>".
        "<td>".$row["price"]."</td>".
        "<td>".$row["quantity"] * $row["price"]."</td></tr>";
        $total_price += $row["quantity"] * $row["price"];
    }
}
?>
        <tr>
            <td colspan="6"></td>
            <td><pre>Total Price = </pre></td>
            <td><?php echo $total_price; ?></td>
        </tr>
    </table>
</body>
</html>