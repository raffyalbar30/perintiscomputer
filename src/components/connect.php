<?php

$selflink = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$myPath = explode("/", $selflink);
array_pop($myPath);

$str = file_get_contents(join("/", $myPath) . "/config/config.json");
$json = json_decode($str, true);
$dbConfig = $json['db_connect'];
try {
    $conn = mysqli_connect($dbConfig['host'], $dbConfig['user'], $dbConfig['pass'], $dbConfig['db_name']);

} catch (PDOException $er) {
    echo $er;

}


// Class
class Model {

    // Constructor
    function __constructor () {



    }

    function getPath () {

        $this->selflink = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $this->myPath = explode("/", $selflink);
        array_pop($this->myPath);
        return $this->myPath;

    }
    
}



?>