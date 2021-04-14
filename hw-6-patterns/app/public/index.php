<?php


require_once  __DIR__ . '/../bootstrap.php';

use App\AppDemo as App;


try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage();
}
