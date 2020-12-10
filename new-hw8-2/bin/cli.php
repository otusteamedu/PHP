<?php


use AYakovlev\Exception\CliException;
use AYakovlev\core\App;

require __DIR__ . "/../vendor/autoload.php";

try {
    $app = new App();
    $app->run($argv);
} catch (CliException $e) {
    echo 'Error: ' . $e->getMessage();
}