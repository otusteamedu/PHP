<?php

require './vendor/autoload.php';

use App\App;

try {
    $app = new App($argv);
    $app->run();
}
catch(Exception $e){

} 