<?php

declare(strict_types=1);

require '../vendor/autoload.php';

use Nlazarev\Hw2_1\AppServer;
use Nlazarev\Hw2_1\AppClient;

switch ($argv[1]) {
    case 'server':
        AppServer::run();
        break;
    case 'client':
        AppClient::run();
        break;
    default:
        echo 'What are you waiting for? Make you happy with server/client params ;)';
}
