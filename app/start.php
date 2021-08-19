<?php

use app\Http\Response\Email\ValidatorResponse;

require_once __DIR__ . '/../bootstrap/init.php';
session_start();
$route = "app\Http\Controllers\\" . explode("?" ,explode("/", $_SERVER['REQUEST_URI'])[1])[0];
$method = (isset(explode("/", $_SERVER['REQUEST_URI'])[2][0]) && explode("/", $_SERVER['REQUEST_URI'])[2][0] != '?')
    ? explode("?" ,explode("/", $_SERVER['REQUEST_URI'])[2])[0]
    : "run";
if (class_exists($route)) {
   try {
        $app = new $route();
        if (method_exists($app, $method)) {
            $app->{$method}();
        }
    } catch (Exception $exception) {
       ValidatorResponse::sendData($exception->getCode(), $exception->getMessage());
    }
}
session_write_close();
