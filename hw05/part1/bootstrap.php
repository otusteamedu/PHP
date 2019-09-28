<?php

use GuzzleHttp\Client;
use App\Validator\{Validator, Ruleset, ErrorBag};
use Pimple\Container;
use Zend\Diactoros\ServerRequestFactory;

require __DIR__ . '/vendor/autoload.php';

$container = new Container();

$container['request'] = function () {
    return ServerRequestFactory::fromGlobals($_SERVER, $_GET, $_POST, $_COOKIE, $_FILES);
};

$container['validator'] = function () {
    return new Validator(new Ruleset, new ErrorBag);
};

$container['http_client'] = function () {
    return new Client();
};
