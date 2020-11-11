<?php

include 'Env.php';

echo 'index.php: hello!<br>';

$dbname = Env::DB_NAME;
$servername = Env::DB_SERVERNAME;
$username = Env::DB_USERNAME;
$password = Env::DB_PASSWORD;

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo 'Connection with database is OK<br>';
} catch(PDOException $e) {
    echo "Connection with database is failed: " . $e->getMessage() . "<br>";
}

phpinfo();
