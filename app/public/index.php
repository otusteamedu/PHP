<?php

require_once '../bootstrap/bootstrap.php';

use Otus\App;
use Otus\View;

try {
    $app = new App();
    $app->run();
} catch (\Exception $e) {
    View::showMessage($e->getMessage());
}
