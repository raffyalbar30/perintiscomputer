<?php

if (!(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'))
    header("location:https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
$selflink = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$myPath = explode("/", $selflink);
$str = "conf/config.json";
if (in_array("admin", $myPath)) 
    $str = "../conf/config.json";

$str = file_get_contents($str);
$json = json_decode($str, true);
$dbConfig = $json['db_connect'];
try {
    $conn = new PDO("mysql:host=" . $dbConfig['host'] . ";dbname=" . $dbConfig['db_name'], $dbConfig['user'], $dbConfig['pass']);

} catch (PDOException $er) {
    echo($er);

}

?>