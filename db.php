<?php
$file = "";
if (file_exists("setting.json")) {
    $file = fopen("setting.json", "r");
} else {
    $file = fopen("..\\setting.json","r");
}
$json = "";
while(!feof($file)) {
    $line = (string) fgets($file);
    $json = $json.$line;
}
fclose($file);

$data = json_decode($json);

$host = "";
$username = "";
$password = "";
$db_name = "";
$appUser = "";
$appPass = "";

if($data->installed){
    $host = $data->host;
    $username = $data->user;
    $password = $data->password;
    $db_name = $data->db;
    $appUser = $data->appuser;
    $appPass = $data->apppassword;
}else{
    header("location:/sales/install.php");
}
?>