<?php

namespace Database;

use PDO;
use PDOException;

class PostgrePDO
{
    public ?PDO $connection;

    /**
     * PostgrePDO constructor.
     */
    public function __construct()
    {
        try {
            $this->connection = new PDO("sqlite:Database/testdb.db");
        } catch (PDOException $e) {
            echo "Error!: " . $e->getMessage();
        }
    }

    public function closeConnection(): void
    {
        $this->connection = null;
    }
}