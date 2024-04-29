<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loging in</title>
</head>
<body>
<?php
    include "db.php";
    if($_POST["username"] === $appUser && $_POST["password"] === $appPass){
        session_start();
        $_SESSION["User"] = $appUser;
    }
    header("location:/sales/");
?>
</body>
</html>