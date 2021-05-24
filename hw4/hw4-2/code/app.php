<?php
require_once './bootstrap/app.php';

use Src\App;

try {
    $app = new App($argv);
    $app->run();
} catch (\Exception $e) {
    header('HTTP/1.0 400 Bad Request');
    echo $e->getMessage();
}
