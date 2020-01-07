<?php
require_once __DIR__ . '/vendor/autoload.php';

$shortopts = "";
$shortopts .= "s:";
$shortopts .= "w:";

$longopts = [
    "socket:",
    "who:",
];

$options = getopt($shortopts, $longopts);

if (isset($options['s'])) {
    $socket_file_name = $options['s'];

    if (isset($options['w'])) {
        if ($options['w'] === 'server') {
            App\UnixServer::start($socket_file_name);
        } elseif ($options['w'] === 'client') {
            App\UnixClient::start($socket_file_name);
        } else {
            echo "server or client" . PHP_EOL;
        }
    } else {
        echo "-w 'server/client'" . PHP_EOL;
    }
} else {
    echo "Добро пожаловать! Правила использования ниже.". PHP_EOL;
    echo("php index.php -s 'название сокета' -w 'server/client'" . PHP_EOL);
}