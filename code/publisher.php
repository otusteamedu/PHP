<?php
declare(strict_types=1);

require __DIR__ . '/bootstrap/bootstrap.php';

use Src\Publisher;

try {
    $publisher = new Publisher();
    $publisher->listen();
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}