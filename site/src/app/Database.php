<?php

namespace App;

class Database
{

    public static function init()
    {


        try {
            $dbh = new \PDO("pgsql:host=" . getenv("POSTGRES_HOST") . ";port=5432;dbname=" . getenv("POSTGRES_DB") . ";user=" . getenv("POSTGRES_USER") . ";password=" . getenv("POSTGRES_PASSWORD"));
        } catch (Exception $e) {
            echo "Unable to connect: " . $e->getMessage() . "<p>";
        }
        return $dbh;
    }
}
