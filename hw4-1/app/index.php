<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use App\App;

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    http_response_code(500);
}