<?php
declare(strict_types=1);

require "vendor/autoload.php";

$server = new \HW4\Server(
    new \HW4\Config\Config('config.ini'),
    new \HW4\Socket\SocketService()
);

try {
    $server->init();
    $server->response();
} catch(\Exception $e) {
    echo $e->getMessage() . PHP_EOL;
    exit(1);
}