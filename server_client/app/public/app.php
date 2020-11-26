<?php

require_once('../vendor/autoload.php');

use Otushw\App;

try {
    $app = new App();
    $app->run();
}
catch(Exception $e){
    echo $e->getMessage() . PHP_EOL;
}