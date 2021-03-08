<?php
require_once ('vendor/autoload.php');

use Src\App;

try {
    $app = new App();
    $app->run();
} catch (\Exception $e) {
    echo $e->getMessage();
}