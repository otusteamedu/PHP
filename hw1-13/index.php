<?php
require_once __DIR__ . '/vendor/autoload.php';

use Src\Services\RestaurantService;
use Src\Strategy\CookingStrategy;

$order = (!empty($argv[1])) ? $argv[1] : null;

if (!empty($order)) {
    $restaurantService = new RestaurantService(new CookingStrategy($order));
    $restaurantService->prepareOrder();
} else {
    echo 'Please, choose some meal you want.' . PHP_EOL;
}