<?php
require('./classes/SocketServer.php');
$socketServer = new SocketServer();
try {
    $socketServer->run();
} catch (Exception $e) {
    echo 'Выброшено исключение: ', $e->getMessage(), "\n";
}
