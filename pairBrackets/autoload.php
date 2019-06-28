<?php

spl_autoload_register(function ($class) {
    $path = __DIR__ . '/src/'. str_replace('\\', '/', $class) . '.php';
    //var_dump($path); die;
    require $path;
});