<?php

require_once __DIR__.'/../vendor/autoload.php';

try {
    (new App\Service\Client())->run();
} catch (\Exception $ex) {
    echo $ex->getMessage()."\n";
}