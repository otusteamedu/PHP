<?php

require 'vendor/autoload.php';

$cfg = new Deadly117\Config('config.ini');

$shortopts = 'm:';
$longopts = ['mode:'];
$options = getopt($shortopts, $longopts);

$mode = $options['m'] ?? $options['mode'];

switch ($mode) {
    case 'server':
        $server = new Deadly117\Socket\Server($cfg);
        $server->run();
        break;
    case 'client':
        $client = new Deadly117\Socket\Client($cfg);
        $client->run();
        break;
    default:
        throw new Exception('unknown mode');
        break;
}