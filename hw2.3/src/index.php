<?php

$serverIp = $_SERVER['SERVER_ADDR'];
$serverName = '';

switch ($serverIp) {
    case '172.30.0.2':
        $serverName = "server 1";
        break;
    case '172.30.0.4':
        $serverName =  "server 2";
        break;
    default:
        $serverName = '';
}

echo 'hello from server ' . $serverName . ' <br>';
echo 'server IP Address - ' . $serverIp . ' <br>';