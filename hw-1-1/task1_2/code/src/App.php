<?php

namespace App;

use Dotenv\Dotenv;

class App
{
    public function run()
    {
        echo 'index.php: hello!<br>';

        $dotenv = Dotenv::createImmutable(__DIR__, './../.env');
        $dotenv->load();

        $dbname = $_ENV['DB_NAME'];
        $servername = $_ENV['DB_SERVERNAME'];
        $username = $_ENV['DB_USERNAME'];
        $password = $_ENV['DB_PASSWORD'];

        try {
            $conn = new \PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

            // set the PDO error mode to exception
            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            echo 'Connection with database is OK<br>';
        } catch(\PDOException $e) {
            echo "Connection with database is failed: " . $e->getMessage() . "<br>";
        }

        phpinfo();
    }
}