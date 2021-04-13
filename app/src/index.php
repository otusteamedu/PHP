<?php

use App\Core\App;

require_once('config.php');
require_once(VENDOR_PATH . DIRECTORY_SEPARATOR. 'autoload.php');
require_once('bootstrap.php');

try {
    $argv = $argv ?? [];

    $app = new App();
    echo $app->run($argv);
} catch(Exception $e){
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
}