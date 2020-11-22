<?php

include_once('vendor/autoload.php');

try {
    $app = new Main();
    $app->run();
} catch (Exception $ex) {
    $app->sendBad($ex->getMessage());
}