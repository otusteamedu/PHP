<?php
echo 'index.php: hello!<br>';

$dbname = 'database_name';
$servername = 'db_container';
$username = 'root';
$password = 'mysql_root_password';

//// homestead
//$dbname = 'homestead';
//$servername = '192.168.10.11';
//$username = 'homestead';
//$password = 'secret';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo 'Connection with database is OK<br>';
} catch(PDOException $e) {
    echo "Connection with database is failed: " . $e->getMessage() . "<br>";
}

phpinfo();
