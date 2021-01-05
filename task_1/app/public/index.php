<?php
require_once('../vendor/autoload.php');

use Otus\App;

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage();
}