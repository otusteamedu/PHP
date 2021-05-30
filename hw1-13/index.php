<?php
require_once './bootstrap/init.php';
use Src\App;

try {
    $app = new App();
    $order = (!empty($argv[1])) ? $argv[1] : null;
    $app->run($order);
} catch (\Exception $exception) {
    echo $exception->getMessage();
}