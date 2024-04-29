<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/sales/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="/sales/bootstrap/css/bootstrap.min.css">
    <title>home</title>
</head>
<body>
    <?php
    session_start();
    if(!isset($_SESSION["User"])){
        header("location:/sales/login.html");
    }
    ?>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Sales Management</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/sales/pricing">Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/sales/report">Reports</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Account
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/sales/logout.php">Log out</a></li>
                        </ul>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-warning" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
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
                <th>Action</th>
            </tr>
<?php
include "db.php";

if(isset($_GET["cart"])){
    header("location:/sales/pdf.php");
}
$my_db = new mysqli($host, $username, $password, $db_name);

$sql = "SELECT * FROM `cart`;";
$cart = $my_db->query($sql);
$cost = 0;
if($cart->num_rows > 0){
    while($row = $cart->fetch_assoc()){
        echo "<tr><form action='/sales/upd.php?item=".$row["id"]."' method='post'>".
                "<td><input type='text' class='form-control' value='".$row["id"]."' disabled></td>".
                "<td><input type='text' class='form-control' value='".$row["product"]."' disabled></td>";
        $sql = "SELECT * FROM `price`;";
        $price = $my_db->query($sql);
        if($price->num_rows > 0){
            while($item = $price->fetch_assoc()){
                if($item["id"] === $row["product"]){
                    echo "<td><input type='text' class='form-control disabled' value='".$item["name"]."' disabled></td>".
                    "<td><input type='text' class='form-control disabled' value='".$item["quantity"]."' disabled></td>";
                    $cost = $item["purchase_price"];
                }
            }
        }
        echo "<td><input type='text' class='form-control disabled' value='".$cost."' disabled></td>".
        "<td><input type='number' name='quantity' class='form-control' value='".$row["quantity"]."'></td>".
        "<td><input type='number' name='price' class='form-control' value='".$row["price"]."'></td>".
        "<td><pre>".
        "<input type='submit' class='btn btn-primary btn-sm' value='Update'> ".
        "<a href='/sales/del.php?item=".$row["id"]."' class='btn btn-danger btn-sm'>Delete</a>".
        "</pre></td>".
        "</form></tr>";
    }
}
?>
            <tr>
                <form action="/sales/insert.php" method="post" id="insertForm">
                    <td></td>
                    <td>
                        <!--<input type="number" name="id" id="id">-->
                        <input name="id" id="id" list="items" class="form-control" onclick='maxVal()'>
                        <datalist id="items">
<?php
$sql = "SELECT * FROM `price` WHERE `quantity` > 0;";
$price = $my_db->query($sql);

if($price->num_rows > 0){
    while($row = $price->fetch_assoc()){
        echo "<option value='" . $row["id"] . "'>". $row["name"] . "</option>";
    }
}
?>
                        </datalist>
                    </td>
                    <td><input type="text" id="name" class="form-control disabled" disabled></td>
                    <td><input type="number" id="total" class="form-control disabled" disabled></td>
                    <td><input type="number" id="cost" class="form-control disabled" disabled></td>
                    <td><input type="number" name="add" id="add" class="form-control" required></td>
                    <td><input type="number" name="selling" id="selling" class="form-control" required></td>
                    <td><input type="button" onclick="submitForm()" value="Add" class="btn btn-warning" class="form-control"></td>
                </form>
            </tr>
            <tr>
                <td colspan="4">
                    <a class="form-control btn btn-primary" href="/sales/report/insert.php">Proceed</a>
                </td>
                <td colspan="4">
                    <a class="form-control btn btn-primary" href="/sales/pdf.php" target="_blank">Print Cart</a>
                </td>
            </tr>
        </table>
    </main>
    <script>
    let items=[];
<?php
echo "";
$record = 0;
$sql = "SELECT * FROM `price`;";
$price = $my_db->query($sql);
if($price->num_rows > 0){
    while($row = $price->fetch_assoc()){
        echo "items[$record] = {id:\"".$row["id"]."\",name:\"".$row["name"]."\",quant:\"".$row["quantity"]."\",price:\"".$row["purchase_price"]."\"};";
        $record += 1;
    }
}
?>
    document.getElementById("id").addEventListener("input", function (){
        var quant = document.getElementById("add");
        var selct = document.getElementById("id");
        for(var item=0; item < items.length; item++){
            if(items[item].id == selct.value){
                quant.max = items[item].quant.toString();
                quant.placeholder = "Max: " + items[item].quant.toString();
                document.querySelector("#total").value=items[item].quant;
                document.querySelector("#name").value=items[item].name;
                document.querySelector("#cost").value=items[item].price;
                break;
            }
        }
    })
    function submitForm(){
        var quant = document.querySelector("#add");
        if(
            document.querySelector("#id").value != ''&&
            document.querySelector("#selling").value != ''&&
            quant.value != ''&&
            quant.value <= quant.max&&
            quant.value > 0
        ){document.querySelector("#insertForm").submit()}
    }
    </script>
    <script src="/sales/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>