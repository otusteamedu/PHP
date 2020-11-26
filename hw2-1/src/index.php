<?php

require_once './vendor/autoload.php';
use App\App;

try {
    $app = new App();
//    $app->run();

    $status = $app->validateEmail('my-box@gmail.com');
    dump($status);
}
catch(\Exception $e){
    echo $e->getMessage() . PHP_EOL;
}
