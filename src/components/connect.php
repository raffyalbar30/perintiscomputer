<?php

$str = file_get_contents('../../config/con.json');
$json = json_decode($str, true);
$dbConfig = $json['db_connect'];

try {
    $conn = mysqli_connect($dbConfig['host'], $dbConfig['user'], $dbConfig['pass'], $dbConfig['db_name']);
} catch (\Throwable $th) {
    //throw $th;
    echo $th;
}

?>