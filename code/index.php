<?php
declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Src\App;

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/');
    $dotenv->load();
    if (empty($_POST['email'])) {
        throw new Exception('Email field if required', 400);
    }
    $app = new App($_POST);
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
