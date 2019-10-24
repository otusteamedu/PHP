<?php
error_reporting(E_ALL);

require_once "classes/SocketConfig.php";
require_once "classes/PingClient.php";
require_once "classes/PongService.php";
require_once "classes/SocketService.php";

$message = implode(" ", array_slice($argv ?? [], 1));
$config = new SocketConfig(__DIR__ . "/config.ini");

try {

    $ping = new PingClient($config);
    $res = $ping->send($message);

    echo "PONG >> ", $res, PHP_EOL;

} catch (Exception $e) {
    echo "ERR: ", $e->getMessage(), PHP_EOL;
    exit;
} finally {
    $ping->close();
}