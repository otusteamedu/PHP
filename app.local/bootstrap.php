<?php

use Dotenv\Dotenv;

define('ROOT', realpath(__DIR__));

require_once ROOT . '/vendor/autoload.php';

$dotEnvDir = ROOT.'/../';
if (is_file($dotEnvDir . '.env')) {
    Dotenv::create($dotEnvDir)->load();
}

error_reporting((int) (getenv('ERROR_REPORTING') ? : E_ALL));

if (!defined('DEBUG')) {
    define('DEBUG', (bool) getenv('DEBUG_MODE'));
}

if (DEBUG) {
    ini_set('display_errors', 1);
} else {
    ini_set('display_errors', 0);
}

// Иногда, при сериализации float строк происходит потеря точности (например 2.8 превращается в 2.7999999..)
// Эта настройка чинит подобне поведение
ini_set('serialize_precision', '-1');
