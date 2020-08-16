<?php

require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

try {
    $db = new \Models\User(new PDO($_ENV['psql_dsn']));

    $User = [
        'firstname' => 'test',
        'lastname'  => 'test',
        'phone'     => '89930131138',
        'company'   => 'webzaim'
    ];

    $user = $db->insert($User);

    echo $user->getFirstname();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "<br/>";
}
