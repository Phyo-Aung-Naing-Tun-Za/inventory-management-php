<?php
namespace App\Database;
use PDO;
use PDOException;
class DB
{
    public $db;
    public function __construct()
    {
       try {
        $this->db = new PDO("mysql:dbname=inventory;host=localhost","root","");
        $this->db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
       } catch (PDOException $e) {
         echo $e->getMessage();
       }
    }

    public function connect()
    {
        return $this->db;
    }
}

