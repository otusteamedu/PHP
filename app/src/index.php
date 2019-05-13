<?php

include_once __DIR__ . '/../vendor/autoload.php';

$dsn = 'pgsql:host=localhost;dbname=cinema;user=cinema;password=1231';
$conn = new PDO($dsn);
var_dump($conn);