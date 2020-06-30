<?php
require __DIR__ . '/config.php';
require __DIR__ . '/Client.php';

$client = new Otus\RYakubov\Client();

$client->listenInput();

