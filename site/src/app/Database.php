<?php

namespace App;

use Exception;

 final class Database

{
     private static $instance;
     private function __construct()
     {
     }
     public static function getInstance(): Database
     {
         if(!self::$instance) {
             self::$instance = new self();
         }

         return self::$instance;
     }

     private function __clone(){}
     private function __wakeup(){}

     public  function init()
    {


        try {
            $dbh = new \PDO("pgsql:host=" . getenv("POSTGRES_HOST") . ";port=5432;dbname=" . getenv("POSTGRES_DB") . ";user=" . getenv("POSTGRES_USER") . ";password=" . getenv("POSTGRES_PASSWORD"));
        } catch (Exception $e) {
            echo "Unable to connect: " . $e->getMessage() . "<p>";
        }
        return $dbh;
    }
}
