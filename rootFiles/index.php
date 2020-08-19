<?php

require "vendor/autoload.php";


use Controllers\DataBaseControllers\PostgresConnection;
use Models\Users\User;
use Models\Users\UserMapper;
use \Controllers\Login\Login;

try {
    $postgresConnection = new PostgresConnection();
    $pdo = new \PDO($postgresConnection->connectionString());
} catch (\PDOException $e) {
    echo $e->getMessage();
}

$userMapper = new UserMapper($pdo);
$user = new User(
    null,
    'aleksei',
    'hello',
    'world'
);

$login = new Login($userMapper);
$login->authenticate($user);




