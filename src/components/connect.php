<?php
// if (!(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'))
//     header("location:https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
$selflink = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$myPath = explode("/", $selflink);
$str = "conf/config.json";
if (in_array("admin", $myPath)) 
    $str = "../conf/config.json";

$str = file_get_contents($str);
$dataConfig = json_decode($str, true);
$dbConfig = $dataConfig['db_connect'];

// Class
class Model {

    // Atribute
    public $dbConfig;
    public $table;
    public $tableArray;
    public $tableRow = 0;
    public $conn;
    public $result;
    protected $query;
    private $tmpArray;
    private $tmpRow;

    // Constructor
    function __construct ($dbConfig, $table) 
    {
        try {

            $this->dbConfig = $dbConfig;
            $this->table = $table;
            $this->getConnecting();
            $this->tableArray = $this->getTableArray();

        } catch (\Throwable $th) {
            echo $th;

        }
    }

    // Method
    function getConnecting () 
    {
        $this->conn = null;
        try {
            $this->conn = mysqli_connect($this->dbConfig['host'], $this->dbConfig['user'], $this->dbConfig['pass'], $this->dbConfig['db_name']);

        } catch (\Throwable $er) {
            error_log($er, 0);

        } 
    }

    // Method
    function getTableArray ($where = "") 
    {
        try {

            $this->tmpArray = [];
            $this->query = "SELECT * FROM " . $this->table;
            if (!empty($where))
                $this->query = "SELECT * FROM " . $this->table . " WHERE " . $where;
            $this->result = mysqli_query($this->conn, $this->query);
            while ($this->tmpRow = mysqli_fetch_array($this->result))
            {
                array_push($this->tmpArray, $this->tmpRow);
                $this->tableRow++;
            }
            return $this->tmpArray;

        } catch (\Throwable $th) {
            echo $th;

        }
    }

    // Method
    function getTableFetch () 
    {
        try {

            $this->query = "SELECT * FROM " . $this->table;
            $this->result = mysqli_query($this->conn, $this->query);

        } catch (\Throwable $th) {
            echo $th;

        }
    }

    // Method
    function getTableLine ($rule)
    {
        try {

            $this->query = "SELECT * FROM " . $this->table . " WHERE " . $rule;
            $this->result = mysqli_query($this->conn, $this->query);
            return mysqli_fetch_array($this->result);

        } catch (\Throwable $th) {
            echo $th;

        }
    }

    // Method
    function deleteTableColoum ($rule)
    {
        try {

            $this->query = "DELETE FROM " . $this->table . " WHERE " . $rule;
            mysqli_query($this->conn, $this->query);

        } catch (\Throwable $th) {
            echo $th;

        }
    }

}

// Model
$ModelProducts = new Model($dbConfig, "`products`");
$ModelWishlist = new Model($dbConfig, "`wishlist`");
$ModelUsers = new Model($dbConfig, "`users`");
$ModelCart = new Model($dbConfig, "`cart`");

?>