<?php

require '../vendor/autoload.php';

use AYakovlev\Core\App;
use AYakovlev\Core\View;

try {
    $app = new App();
    $app->run();
} catch (\AYakovlev\Exception\DbException $e) {
    View::render("500", (array) $e->getMessage(), 500);
} catch (Exception $e) {
    echo $e->getMessage();
}
