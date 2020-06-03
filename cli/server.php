<?php
if (php_sapi_name() !== 'cli') {
    throw new Exception('Access denied');
}

require_once __DIR__.'/../vendor/autoload.php';

use Noodlehaus\Config;
use Socket\Raw\Factory;

$config = new Config(__DIR__.'/../config/server.ini');
if (($address = $config->get('socket')) === null) {
    throw new Exception('Property "socket" is not set in config');
}

$factory = new Factory();

$socket = $factory->createServer($address);

try {
    while ($c = $socket->accept()) {
        $c->write('Hello');
        echo 'Client connected'.$c->getPeerName().PHP_EOL;
//        if ($socket->selectRead()) {
//
//        }
        $request = $c->read(2048);
        [$cmd, $params] = explode(' ', $request);
        echo 'Command '.$request.PHP_EOL;
        switch ($cmd) {
            case 'user.list':
                $c->write($config->get('users'));
                break;
            case 'user.add':
                $users = ($usersRaw = $config->get('users')) ? explode(',', $usersRaw) : [];
                $users[] = $params;
                $config->set('users', implode(',', array_unique(array_filter($users))));
                $c->write('Ok');
                break;
            default:
                $c->write("Command {$cmd} is not found. Use: user.list, user.add [user]");
        }

        $c->close();
    }
} finally {
    $socket->close();
}

