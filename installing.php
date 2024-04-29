<?php
$host = $_POST["host"];
$user = $_POST["user"];
try{$password = $_POST["password"];}catch(Exception $e){$password = "";};
$db = $_POST["database"];
$appuser = $_POST["appuser"];
$apppassword = $_POST["apppassword"];

$data = '{"installed":true,'.
    '"host":"'.$host.'",'.
    '"user":"'.$user.'",'.
    '"password":"'.$password.'",'.
    '"db":"'.$db.'",'.
    '"appuser":"'.$appuser.'",'.
    '"apppassword":"'.$apppassword.'"}';
$file = fopen("setting.json","w");
fwrite($file, $data);
fclose($file);

$db_con = new mysqli($host, $user, $password);
$sql = "CREATE DATABASE `$db`";
if ($db_con->query($sql) === TRUE) {
  echo "Database created successfully";
} else {
  echo "Error creating database: " . $db_con->error;
}
$db_con->close();

$db_con = new mysqli($host, $user, $password, $db);
$sql = "";

$file = fopen("install.sql","r");
while(!feof($file)) {
    $sql = (string) fgets($file);
    if (trim($sql) !== "") {
        echo "<h2>$sql</h2>";
        $db_con->query($sql);
    }
}
fclose($file);
header("location:/sales/");
?>