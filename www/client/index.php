<?php

use Symfony\Component\Dotenv\Dotenv;
use Bramus\Router\Router;

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', $_SERVER['DOCUMENT_ROOT']);

include_once(ROOT . DS . 'vendor' . DS . 'autoload.php');

(new Dotenv())->load(ROOT . DS . '.env');

$route = new Router();

$route->get('/insert', '\Controllers\ApiController@insert');
$route->get('/get/{id}', '\Controllers\ApiController@get');

$route->run();




