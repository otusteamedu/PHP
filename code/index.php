<?php
echo 'index.php: hello!<br>';

$servername = 'db_container';
$username = 'root';
$password = 'mysql_root_password';
$dbname = 'database_name';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo 'Connection with database is OK<br>';
} catch(PDOException $e) {
    echo "Connection with database is failed: " . $e->getMessage() . "<br>";
}

phpinfo();
