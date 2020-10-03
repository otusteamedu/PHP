<?php

require __DIR__ . '/../vendor/autoload.php';
(Dotenv\Dotenv::createImmutable(__DIR__ . '/../',))->load();

use \App\App;

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage();
}
