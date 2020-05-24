<?php

require 'vendor/autoload.php';

$cfg = new Deadly117\Config('config.ini');
$file = $cfg->getValue('socket.file');

$shortopts = 'm:';
$longopts = ['mode:'];
$options = getopt($shortopts, $longopts);

$mode = $options['m'] ?? $options['mode'];

switch ($mode) {
    case 'server':
        $server = new Deadly117\Socket\Server($file);
        $server->run();
        break;
    case 'client':
        $client = new Deadly117\Socket\Client($file);
        $client->run();
        break;
    default:
        throw new Exception('unknown mode');
        break;
}