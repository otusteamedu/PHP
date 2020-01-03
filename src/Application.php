<?php

namespace Tirei01\Hw4;

use Tirei01\Hw4\Socket\Client;
use Tirei01\Hw4\Socket\Server;

class Application
{
    public function __construct()
    {

    }

    public function run()
    {
        echo "Enter \"server\" or \"client\"";
        echo PHP_EOL;
        while (false !== ($line = fgets(STDIN))) {
            $line = trim($line);
            switch ($line) {
                case 'server':
                    echo 'init server' . PHP_EOL;
                    $obConf = new Config('server');
                    $obServer = new Server($obConf->get('socket_name'));
                    $obServer->loop();
                    break;
                case 'client':
                    echo 'init client' . PHP_EOL;
                    $obConf = new Config('client');
                    $obClint = new Client($obConf->get('socket_name'));
                    $obClint->loop();
                    break;
                case 'exit':
                    break 2;
                    break;
            }
        }
    }
}