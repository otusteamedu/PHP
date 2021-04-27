<?php


namespace Marchenko;

use Marchenko\BaseSocket;
use Exception;

class Server extends BaseSocket
{
    const STOP = 'stop';

    public function __construct($pathConfig)
    {
        parent::__construct($pathConfig);

        if (file_exists($this->pathSocket)) {
            unlink($this->pathSocket);
        }
        if (!socket_bind($this->socket, $this->pathSocket)) {
            return new Exception('Can\'t bind socket');
        }
        if (!socket_listen($this->socket, 1)) {
            return new Exception('Can\'t connect socket');
        }
    }

    public function run()
    {
        $msg = $this->read();
        echo "Received $msg" . PHP_EOL;
    }

    private function read()
    {
        $socket = socket_accept($this->socket);
        return socket_read($socket, 1024);
    }
}
