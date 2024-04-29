<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/sales/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="/sales/bootstrap/css/bootstrap.min.css">
    <style>
        label{
            position: relative;
            display: block;
            width: 50%;
            margin: auto;
            overflow: hidden;
        }
    </style>
    <title>Installtion</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Sales Management</a>
        </div>
    </nav>
    <form class="container" action="installing.php" method="post" id="form">
        <label class="form-control">
            DataBase Host:
            <input type="text" name="host" id="host" class="form-control" required>
        </label>
        <label class="form-control">
            Privilaged User:
            <input type="text" name="user" id="user" class="form-control" required>
        </label>
        <label class="form-control">
            Password:
            <input type="password" name="password" id="password" class="form-control" value="">
        </label>
        <label class="form-control">
            DataBase Name:
            <input type="text" name="database" id="database" class="form-control">
        </label>
        <label class="form-control">
            New App User:
            <input type="text" name="appuser" id="appuser" class="form-control" required>
        </label>
        <label class="form-control">
            New Password:
            <input type="password" name="apppassword" id="apppassword" class="form-control" required>
        </label>
        <label class="form-control">
            Confirm Password:
            <input type="password" name="conpassword" id="conpassword" class="form-control" required>
        </label>
        <label class="form-control">
            <input type="button" onclick="submitForm()" class="btn btn-primary btn-lg" value="Install">
        </label>
    </form>
<?php
$file = fopen("setting.json","r");
$json = "";
while(!feof($file)) {
    $line = (string) fgets($file);
    $json = $json.$line;
}
fclose($file);
$data = json_decode($json);

if($data->installed){
    header("location:/sales/");
}
?>
    <script>
        function submitForm(){
            var form = document.getElementById("form");
            var paswd = document.getElementById("apppassword");
            var cpass = document.getElementById("conpassword");
            if(paswd.value == cpass.value){
                form.submit();
            }else{
                alert("Password and confirm password doesn't match");
            }
        }
    </script>
    <script src="/sales/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>