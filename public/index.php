<?php

use \Services\Spider;

require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

try {
    (new Spider(new \Sources\Animevost(), new \DB\Mongodb()))
        ->getTop()
        ->save();
} catch (Exception $e) {
    echo 'Error: ',  $e->getMessage(), "\n";
}




