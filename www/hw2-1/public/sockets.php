<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';

use Nlazarev\Hw2_1\AppServerSocket;
use Nlazarev\Hw2_1\AppClientSocket;

switch ($argv[1]) {
    case 'server':
        AppServerSocket::run();
        break;
    case 'client':
        AppClientSocket::run();
        break;
    default:
        echo 'What are you waiting for? Make you happy with server/client params ;)';
}
