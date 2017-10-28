<?php
/**
 * Created by PhpStorm.
 * User: Jim
 * Date: 27-Oct-17
 * Time: 10:41
 */
namespace App\DB;
use PDO;

class Connection {

    public $con;

    /**
     * Connection constructor.
     */
    public  function __construct() {
        $db_username = 'root';
        $db_password = 'admin';
        $db_host = 'localhost';
        $db_db = 'hogerlager';
        $charset = 'utf8mb4';
        $dsn = "mysql:host=$db_host;dbname=$db_db;charset=$charset";
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_CLASS,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $this->con = new PDO($dsn, $db_username, $db_password, $opt);
            if ($this->con instanceof PDO) {
                return $this->con;
            }
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
    public function getDb() {
        if ($this->con instanceof PDO) {
            return $this->con;
        }
    }
}