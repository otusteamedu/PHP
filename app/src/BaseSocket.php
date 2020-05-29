<?php


namespace Marchenko;

use Marchenko\Config;
use Exception;

class BaseSocket
{
    const VAR_SOCKET = 'server_socket';

    protected $socket;
    protected $pathSocket;

    public function __construct($pathConfig)
    {
        $config = new Config($pathConfig);
        $this->pathSocket = $config->get(BaseSocket::VAR_SOCKET);

        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if ($this->socket == false) {
            throw new Exception('Can\'t create socket');
        }
    }

    public function __destruct()
    {
        socket_shutdown($this->socket, 2);
        socket_close($this->socket);
    }
}
