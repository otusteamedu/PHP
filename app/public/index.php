<?php
require_once '../bootstrap/bootstrap.php';

use VideoPlatform\App;

try {
    $app = new App();
    $app->run();
} catch (\Exception $e) {
    echo $e->getMessage();
}
