<?php

use \Bramus\Router\Router;

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', $_SERVER['DOCUMENT_ROOT']);

include_once(ROOT . DS . 'vendor' . DS . 'autoload.php');

$route = new Router();

$route->get('/app', '\Controllers\QueueController@index');

$route->run();
