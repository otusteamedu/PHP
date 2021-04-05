<?php
require __DIR__ . '/config.php';
require __DIR__ . '/Client.php';

$client = new Otus\Azatnizam\Client();

$client->listenInput();

