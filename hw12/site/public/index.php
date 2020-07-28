<?php

require '../vendor/autoload.php';

use AYakovlev\Core\App;

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage();
}
