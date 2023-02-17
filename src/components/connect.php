<?php

$selflink = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$myPath = explode("/", $selflink);
array_pop($myPath);

$str = file_get_contents("conf/config.json");
$json = json_decode($str, true);
$dbConfig = $json['db_connect'];
try {
    $conn = new PDO("mysql:host=" . $dbConfig['host'] . ";dbname=" . $dbConfig['db_name'], $dbConfig['user'], $dbConfig['pass']);

} catch (PDOException $er) {
    error_log($er, 0);

}

?>