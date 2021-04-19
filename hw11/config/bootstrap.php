<?php

use App\Kernel;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;

require_once('./vendor/autoload.php');

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/../.env');

function runApplication()
{
    $kernel = new Kernel('dev', true);
    $request = Request::createFromGlobals();
    $response = $kernel->handle($request);
    $response->send();
    $kernel->terminate($request, $response);
}
