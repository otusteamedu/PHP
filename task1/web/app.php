<?php
require_once __DIR__.'/../vendor/autoload.php';

use App\Application;
use App\Request;

try {
    $request = new Request($_GET, $_POST);
    $app = new Application($request);
    $app->run();
} catch (Exception $exception) {
    http_response_code(500);
    print 'Internal Server Error. '.$exception->getMessage();
}