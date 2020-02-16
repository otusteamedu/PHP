<?php

namespace App\Database;

use Dotenv;

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__FILE__).'/../../../');
$dotenv->load();

class Database
{
    public static function init()
    {
        try {
            $dbh = new \PDO(
                "pgsql:host="
                . getenv("DATABASE_HOST")
                . ";port=5432;dbname="
                . getenv("DATABASE_NAME")
                . ";user=" . getenv("DATABASE_USER")
                . ";password="
                . getenv("DATABASE_PASSWORD"));
        } catch (Exception $e) {
            echo "Unable to connect: " . $e->getMessage() . "<p>";
        }
        return $dbh;
    }
}