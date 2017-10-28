<?php
/**
 * Created by PhpStorm.
 * User: Jim
 * Date: 27-Oct-17
 * Time: 10:41
 */



namespace App\Models;

use App\DB\Connection;
use PDO;

class User {
    /**
     * @var string|null
     */
    public $name;

    /**
     * @var int|null
     */
    public $tries;

    /**
     * User constructor.
     * @param null $name
     * @param null $tries
     */
    public function __construct($name = null, $tries=null) {
        if ($name!==null) $this->name = $name;
        if ($tries!==null) $this->tries = $tries;
    }

    /**
     * @return array
     */
    public static  function all() {
        $db = new Connection();
        $stmt = $db->con->prepare('SELECT name, tries FROM results');
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_CLASS , '\App\Models\User');
        return $users;
    }

    /**
     * @return bool
     */
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cName = stripcslashes(trim($this->name));
            $cTries = $this->tries;
            $db = new Connection();
            $stmt = $db->con->prepare('INSERT INTO results (name, tries) VALUES (?, ?)');
            $stmt->bindParam('1', $cName);
            $stmt->bindParam('2', $cTries);
            if($stmt->execute()) {
                header('/results.php');
            }
        }
        return true;
    }
}