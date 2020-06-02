<?php
require_once "\Server.php";
require_once "\Client\Client.php";

if (php_sapi_name() !== 'cli') {
    die();
}

$shortopt = 'c';
$longopt = [
    'client',
];

$options = getopt($shortopt, $longopt);

if (count($options) === 0) {
    new Server\Server();
} else {
    new Client\Client();
}