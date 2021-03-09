<?php
require_once './bootstrap/init.php';

use Src\App;

try {
    $app = new App($argv);
    $app->run();
} catch (\Exception $exception) {
    http_response_code(400);
    echo $exception->getMessage();
}