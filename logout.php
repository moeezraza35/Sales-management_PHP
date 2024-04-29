<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loging out</title>
</head>
<body>
<?php
    session_start();
    unset($_SESSION['User']);
    header("location:/sales/");
?>
</body>
</html>