<?php

namespace Deadly117\Socket;

use Exception;
use Socket\Raw\Factory;
use Deadly117\Config;

class Client
{
    private $socket;

    public function __construct(Config $cfg)
    {
        $endpoint = $cfg->getValue('socket.file');

        if (!file_exists($endpoint)) {
            throw new Exception('socket not found');
        }

        $factory = new Factory();
        $this->socket = $factory->createClient("unix://{$endpoint}");
    }

    public function run()
    {
        $data = mt_rand();

        echo 'client send: ', $data, PHP_EOL;
        $this->socket->write($data . PHP_EOL);

        while (true) {
            $result = trim($this->socket->read(256, PHP_NORMAL_READ));

            if (empty($result)) {
                usleep(300000);
                continue;
            }

            echo 'client recv: ', $result, PHP_EOL;

            echo 'client exiting', PHP_EOL;
            $this->socket->write('exit' . PHP_EOL);
            break;
        }

        $this->socket->close();
    }
}