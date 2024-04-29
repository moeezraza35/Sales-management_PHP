<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/sales/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="/sales/bootstrap/css/bootstrap.min.css">
    <title>Pricing</title>
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
                        <a class="nav-link active" href="#" aria-current="page">Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/sales/report">Reports</a>
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
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-warning" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
    <main class="container">
        <h2>Pricing</h2>
        <table class="table table-striped">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Quantity</th>
                <th>Purchase Price</th>
                <th>Action</th>
            </tr>
<?php
session_start();
if(!isset($_SESSION["User"])){
    header("location:/sales/login.html");
}
include "../db.php";
$my_db = new mysqli($host, $username, $password, $db_name);
$sql = "SELECT * FROM `price`;";
$result = $my_db->query($sql);
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        echo '<tr>'.
                '<form action="/sales/pricing/update.php" method="post">'.
                '<td><input type="number" id="'.$row["id"].'_id" name="id" class="form-control-plaintext" value="'.$row["id"].'"></td>'.
                '<td><input type="text" id="'.$row["id"].'name" name="name" class="form-control-plaintext" value="'.$row["name"].'"></td>'.
                '<td><input type="number" id="'.$row["id"].'quantity" name="quantity" class="form-control-plaintext" value="'.$row["quantity"].'"></td>'.
                '<td><input type="number" id="'.$row["id"].'purchase_price" name="purchase_price" class="form-control-plaintext" value="'.$row["purchase_price"].'"></td>'.
                '<td><pre><input type="submit" value="Update" class="btn btn-primary btn-sm"> <a href="/sales/pricing/delete.php?id='.$row["id"].'" class="btn btn-sm btn-danger">Delete</a></pre></td>'.
                '</form>'.
            '</tr>';
    }
}
?>
            
            <tr>
                <form action="/sales/pricing/insert.php" method="post">
                    <td><input type="number" name="id" id="id" class="form-control"></td>
                    <td><input type="text" name="name" id="name" class="form-control"></td>
                    <td><input type="number" name="quantity" id="quantity" class="form-control"></td>
                    <td><input type="number" name="purchase_price" id="purchase_price" class="form-control"></td>
                    <td><input type="submit" value="Insert" class="btn btn-warning" class="form-control"></td>
                </form>
            </tr>
        </table>
    </main>
    <script src="/sales/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>