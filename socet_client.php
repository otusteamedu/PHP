<?php
require('./classes/SocketClient.php');
$head = "GET / HTTP/1.1\r\n" .
    "Host:  0.0.0.0:8000\r\n" .
    "Accept: */*\r\n" .
    "Body: Это клиент\r\n";

$socketClient = new SocketClient();
$socketClient->sendQuery($head);
