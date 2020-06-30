<?php
require __DIR__ . '/config.php';
require __DIR__ . '/Server.php';

$server = new Otus\RYakubov\Server();

$server->listenSocket();
