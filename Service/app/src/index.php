<?php

use Service\Core\App;

require_once('../vendor/autoload.php');

try {
    $app = new App();
    $app->run();
} catch(Exception $e){
    echo 'Error: ' . $e->getMessage();
}