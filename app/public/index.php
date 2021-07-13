<?php

require '../vendor/autoload.php';

use App\App;
use App\Response;

try {
    $app = new App();
    $app->run();
} catch (\Throwable $e) {
   Response::send($e->getCode(), $e->getMessage());
}
