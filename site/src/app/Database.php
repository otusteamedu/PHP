<?php
namespace App;

use MongoDB;

class Database{

    public $db;

    public function __construct()
    {
        $this->db=new MongoDB\Client("mongodb://mongo:27017");
    }






}
