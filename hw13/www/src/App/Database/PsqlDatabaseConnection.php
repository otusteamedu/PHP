<?php

namespace App\Database;

class PsqlDatabaseConnection implements DatabaseConnectionInterface
{
    public function connect()
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