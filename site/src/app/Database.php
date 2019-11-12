<?php
namespace App;

use MongoDB;

class Database{
    const dns='mongo';
    const port='27017';
    const protocol='mongodb';
    const username='admin';
    const pass='12345';



    public $db;

    public function __construct()
    {
      $this->db = new MongoDB\Client(self::protocol."://".self::dns.":".self::port);
    }






}
