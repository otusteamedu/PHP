<?php
error_reporting(0);

require_once "classes/SocketConfig.php";
require_once "classes/PingClient.php";
require_once "classes/PongService.php";
require_once "classes/SocketService.php";

$config = new SocketConfig(__DIR__ . "/config.ini");

try {
    $pong = new PongService($config);
    $pong->listen();
} catch (Exception $e) {
    print_r($e->getTrace());
    echo "ERR: ", $e->getMessage(), PHP_EOL;
    exit;
} finally {
    $pong->close();
}