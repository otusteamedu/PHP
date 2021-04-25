<?php

use App\App;

require_once __DIR__ . '/vendor/autoload.php';
try {
    $app = new App();
    echo $app->run();
} catch (Throwable $e) {
    echo  $e->getMessage() . "\n";
}
