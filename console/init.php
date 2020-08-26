<?php

require __DIR__ . '/../bootstrap/app.php';

if ($argv[1] !== '') {
    $file = __DIR__ . '/sockets/' . $argv[1] . '.php';
    if (file_exists($file)) {
        require $file;
    }
}