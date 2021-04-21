<?php
require_once __DIR__ . '/bootstrap/bootstrap.php';

use Src\Facade\RestaurantFacade;

$order = (!empty($argv[1])) ? $argv[1] : null;

if (!empty($order)) {
    $facade = new RestaurantFacade($order);
    $facade->takeOrder();
} else {
    echo 'Please, choose some meal you want.' . PHP_EOL;
}