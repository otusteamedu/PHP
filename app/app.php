<?php

define('ROOT', dirname(__DIR__));

require ROOT . '/vendor/autoload.php';
require ROOT . '/bootstrap/app.php';

use Otus\Http\App;

// 4.1
if ($argv[1] === '') {
    try {
        $app = new App();
        $app->run();
    } catch (Exception $e) {
        echo 'exception ' . $e;
    }
}

// 4.2
if ($argv[1] !== '') {
    $file = ROOT . '/sockets/' . $argv[1] . '.php';
    if (file_exists($file)) {
        require $file;
    }
}