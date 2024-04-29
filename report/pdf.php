<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
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
<?php
include "../db.php";
$my_db = new mysqli($host, $username, $password, $db_name);
$sql = "SELECT `date` FROM `sales` ORDER BY `date`;";
$result = $my_db->query($sql);
$dates = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $dates[] = $row["date"];
    }
}
?>
    <main class="container">
        <h1>Report</h1>
        <table>
            <tr>
                <th>
                    sr
                </th>
                <th>
                    Product ID
                </th>
                <th>
                    Product Name
                </th>
                <th>
                    Purchase Price
                </th>
                <th>
                    Selling Price
                </th>
                <th>
                    Quantity
                </th>
                <th>
                    Total Price
                </th>
                <th>
                    Date
                </th>
            </tr>
<?php
session_start();
if(!isset($_SESSION["User"])){
    header("location:/sales/login.html");
}
$sql = "SELECT * FROM `sales` WHERE `date` >= '".$_GET["from"]."' AND `date` <= '".$_GET["to"]."';";
$result = $my_db->query($sql);
$sql = "SELECT * FROM `price`;";
$product = $my_db->query($sql);
$items = array();
$purchase = 0;
$selling = 0;
if($product->num_rows > 0){while($item = $product->fetch_assoc()){
    $items[] = $item;
}}
$sr = 1;
if($result->num_rows > 0){while($row = $result->fetch_assoc()){
    echo "<tr><td>".$sr."</td>".
    "<td>".$row["product"]."</td>";
    $sr += 1;
    foreach($items as $item){if($item["id"] === $row["product"]){
        echo "<td>".$item["name"]."</td>".
        "<td>".$item["purchase_price"]."</td>";
        $purchase += $item["purchase_price"];
    }};
    echo "<td>".$row["price"]."</td>".
    "<td>".$row["quantity"]."</td>".
    "<td>".$row["price"] * $row["quantity"]."</td>".
    "<td>".$row["date"]."</td></tr>";
    $selling += $row["price"] * $row["quantity"];
}}
?>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td>Total Purchase = </td>
                <td><?php echo $purchase ?></td>
                <td></td>
                <td>Total Price = </td>
                <td><?php echo $selling ?></td>
                <td></td>
            </tr>
        </table>
    </main>
</body>
</html>