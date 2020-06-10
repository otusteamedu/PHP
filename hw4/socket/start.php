<?php

require_once "Server/Server.php";
require_once "Client/Client.php";

use Server\Server;

if (php_sapi_name() !== 'cli' || $argc === 1) {
    die('Not arguments');
}

$shortopt = 'sc';
$longopt = [
    'client',
    'server',
    'close',
];
$options = getopt($shortopt, $longopt);
$client = isset($options['c']) ? true : (isset($options['client']) ? true : false);
$server = isset($options['s']) ? true : (isset($options['server']) ? true : false);

if (!$client && !$server) {
    die('Client or Server');
}
if ($client) {

}

if ($server) {
    new Server();
}