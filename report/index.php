<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/sales/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="/sales/bootstrap/css/bootstrap.min.css">
    <title>Report</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container">
            <a class="navbar-brand" href="/sales/">Sales Management</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/sales/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/sales/pricing">Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#" aria-current="page">Reports</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Account
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item"href="/sales/logout.php">Log out</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-warning" type="submit">Search</button>
            </form>
        </div>
    </nav>
<?php
include "../db.php";
session_start();
if(!isset($_SESSION["User"])){
    header("location:/sales/login.html");
}
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
        <h2>Report</h2>
        <form action="#" method="get">
            <table class="table">
                <tr>
                    <td title="Date From">
                        <input type="date" name="from" placeholder="Date from" class="form-control" <?php
                        if(isset($dates[0]) && isset($dates[count($dates)-1])){
                            echo "min=\"".$dates[0]."\"";
                            echo "max=\"".$dates[count($dates)-1]."\"";
                        }else{
                            echo "disabled";
                        }
                    ?>></td>
                    <td title="Date To">
                        <input type="date" name="to" placeholder="Date to" class="form-control" <?php
                        if(isset($dates[0]) && isset($dates[count($dates)-1])){
                            echo "min=\"".$dates[0]."\"";
                            echo "max=\"".$dates[count($dates)-1]."\"";
                        }else{
                            echo "disabled";
                        }
                    ?>></td>
                    <td>
                        <input type="submit" value="Get" class="btn btn-warning">
                    </td>
                </tr>
            </table>
        </form>
        <table class="table table-striped-columns">
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
if(isset($_GET["from"]) && isset($_GET["to"])){
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
    echo
    "</tr>".
    "<tr>".
        "<td colspan=\"2\"></td>".
        "<td>Purchaseing Sub Total = </td>".
        "<td>".$purchase."</td>".
        "<td></td>".
        "<td>Selling Sub Total = </td>".
        "<td>".$selling."</td>".
        "<td></td>".
    "</tr>".
    "</table>".
    "<section class=\"d-flex justify-content-evenly\" style=\"padding-bottom: 15px;\">".
    "<a class=\"btn btn-primary btn-lg\" href=\"/sales/report/pdf.php/?from=".$_GET["from"]."&to=".$_GET["to"]."\"  target=\"_blank\">Print Report</a>";
}else{
    echo "</table>";
}
?>
        </section>
    </main>
    <script src="/sales/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>