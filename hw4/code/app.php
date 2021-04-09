<?php

require_once(__DIR__ . '/vendor/autoload.php');

use Otus\App\App;

try {
    $app = new App();
    $app->run();
}
catch(Exception $e){

}