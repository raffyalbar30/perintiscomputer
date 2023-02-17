<?php

$str = file_get_contents('../../config/con.json');
$json = json_decode($str, true);
$dbConfig = $json['db_connect'];

try {
    $conn = new mysqli($dbConfig['host'], $dbConfig['user'], $dbConfig['pass'], $dbConfig['db_name']);

} catch (PDOException $er) {
    echo $er;

}

?>