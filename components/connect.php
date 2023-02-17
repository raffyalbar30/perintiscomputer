<?php

$db_name = 'mysql:host=localhost;dbname=project';
$user_name = 'root';
$user_password = '';

// $conn = new PDO($db_name, $user_name, $user_password);

// $db_name = 'mysql:host=sql111.epizy.com;dbname=epiz_31988944_dustech';
// $user_name = 'epiz_31988944';
// $user_password = 'M5TiMTVvNe9';

$conn = new PDO($db_name, $user_name, $user_password);

?>