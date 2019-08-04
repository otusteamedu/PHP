<?php

function __autoload($class)
{
    $path = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';
   // var_dump($path);die;
    require $path;
}