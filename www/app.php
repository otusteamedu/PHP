<?php

use Dotenv\Dotenv;

include_once __DIR__ . '/vendor/autoload.php';

try{
    set_time_limit(0);

    $env = Dotenv::createImmutable(dirname(__FILE__));
    $env->load();

    $driver =  new Classes\Driver();
    $driver->run($argv[1]);

} catch (Exception $ex) {
    echo $ex->getMessage();
}
