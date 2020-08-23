<?php

require_once 'bootstrap/app.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$errorMessage = 'Введите, пожалуйста, режим запуска скрипта (client / server)';

if (isset($argv['1'])) {
    switch ($argv['1']) {
        case 'server':
            require_once 'console/sockets/server.php';
            break;
        case 'client':
            require_once 'console/sockets/client.php';
            break;
        default:
            echo $errorMessage;
    }
} else {
    echo $errorMessage;
}