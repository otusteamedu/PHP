<?php

require_once '../vendor/autoload.php';

use Socket\Socket;

try {
    $app = new Socket();
    $app->run($argv);
} catch (Exception $e) {
    echo $e->getMessage();
}
