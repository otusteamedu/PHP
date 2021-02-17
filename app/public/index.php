<?php

require_once '../bootstrap/bootstrap.php';

use Otus\App;

try {
    $app = new App();
    $app->run();
} catch (\Exception $e) {
    echo $e->getMessage();
}
