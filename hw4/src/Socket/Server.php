<?php

namespace Deadly117\Socket;

use Exception;
use Socket\Raw\Factory;

class Server
{
    private $socket;

    public function __construct($endpoint)
    {
        if (file_exists($endpoint)) {
            $done = unlink($endpoint);
            if (!$done) {
                throw new Exception('socket unlink fail');
            }
        }

        $factory = new Factory();
        $this->socket = $factory->createServer("unix://{$endpoint}");
    }

    public function run()
    {
        $client = $this->socket->accept();

        while (true) {
            $data = trim($client->read(256, PHP_NORMAL_READ));

            if (empty($data)) {
                usleep(300000);
                continue;
            }

            if ($data === 'exit') {
                echo 'server exiting', PHP_EOL;
                $client->close();
                break;
            }

            echo 'server recv: ', $data, PHP_EOL;

            $result = md5($data);
            echo 'server send: ', $result, PHP_EOL;
            $client->write($result . PHP_EOL);
        }

        $this->socket->close();
    }
}