<?php

$host='db';
$db = 'test';
$username = 'postgres';
$password = 'newDAy01';


$dsn = "pgsql:host=$host;port=5432;dbname=$db;user=$username;password=$password";

try{
    // create a PostgreSQL database connection
    $conn = new PDO($dsn);

    // display a message if connected to the PostgreSQL successfully
    if($conn){
        echo "Connected to the <strong>$db</strong> database successfully!";
    }
}catch (PDOException $e){
    // report error message
    echo $e->getMessage();
    echo "<br/>";
    echo $e->getTraceAsString();
}
?>
