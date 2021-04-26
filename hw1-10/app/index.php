<?php
require_once './bootstrap/init.php';

use Src\App;

try {
    $app = new App();
    $app->run();
} catch (\Exception $exception) {
    echo $exception->getMessage();
}
