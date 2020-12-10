<?php

use Controllers\RouterController;

include_once(__DIR__ . '/vendor/autoload.php');
include_once(__DIR__ . '/bootstrap.php');

try {
    (new RouterController())
        ->run();
} catch (Exception $e) {
   echo json_encode(['error' => 'Выброшено исключение: ' . $e->getMessage() ]);
}



