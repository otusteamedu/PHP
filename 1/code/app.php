<?php
require_once 'vendor/autoload.php';

use Src\Handler;

try {
    $string = $_POST['string'] ?? null;
    if ($string) {
        $handler = new Handler($string);
        $handler->run();
    } else {
        echo 'string property must be set.' . PHP_EOL;
    }
} catch (RuntimeException $e) {
    echo $e->getMessage();
}