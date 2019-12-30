<?php

namespace App;

use Exception;
use PDO;

/**
 * Class Database
 * @package App
 */
final class Database

{
    /**
     * @var
     */
    private static $instance;

    /**
     * Database constructor.
     */
    private function __construct()
     {
     }

    /**
     * @return Database
     */
    public static function getInstance(): Database
     {
         if(!self::$instance) {
             self::$instance = new self();
         }

         return self::$instance;
     }

    /**
     *
     */
    private function __clone(){}

    /**
     *
     */
    private function __wakeup(){}

    /**
     * @return PDO
     */
    public  function init()
    {


        try {
            $dbh = new PDO("pgsql:host=" . getenv("POSTGRES_HOST") . ";port=5432;dbname=" . getenv("POSTGRES_DB") . ";user=" . getenv("POSTGRES_USER") . ";password=" . getenv("POSTGRES_PASSWORD"));
        } catch (Exception $e) {
            echo "Unable to connect: " . $e->getMessage() . "<p>";
        }
        return $dbh;
    }
}
