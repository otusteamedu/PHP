<?php

use Controllers\AppController;

try {
    (new AppController())
        ->run();
} catch (Exception $e) {
   echo json_encode(['error' => 'Выброшено исключение: ' . $e->getMessage() ]);
}



