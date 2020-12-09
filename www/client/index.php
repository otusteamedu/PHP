<?php

use Symfony\Component\Dotenv\Dotenv;
use Controllers\RouterController;

include_once(__DIR__ . '/vendor/autoload.php');

(new Dotenv())->load(__DIR__ . '/.env');

try {
    (new RouterController())
        ->run();
} catch (Exception $e) {
   echo json_encode(['error' => 'Выброшено исключение: ' . $e->getMessage() ]);
}



