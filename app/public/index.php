<?php

require __DIR__ .  '/../bootstrap/bootstrap.php';

use Otushw\App;

try {
    $app = new App();
    $app->run();
} catch (Exception $e) {
    var_dump($e->getMessage());
}