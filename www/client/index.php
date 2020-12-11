<?php

use Controllers\AppController;

include_once(__DIR__ . '/vendor/autoload.php');

try {
    (new AppController())
        ->run();
} catch (Exception $e) {
   echo json_encode(['error' => 'Выброшено исключение: ' . $e->getMessage() ]);
}



