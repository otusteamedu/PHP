<?php

namespace Otushw;

use Exception;

class Socket
{
    protected $socket;
    protected $pathSocket;
    protected $portSocket;

    const PATH_CONFIG = '/var/www/PHP/server_client/app/config.ini';

    public function __construct()
    {
        $config = new Config(self::PATH_CONFIG);
        $this->pathSocket = $config->readParam('SOCKET_PATH');
        $this->portSocket = $config->readParam('SOCKET_PORT');

        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        if ($this->socket == false) {
            throw new Exception("Can't create socket");
        }
    }

    public function __destruct()
    {
        socket_shutdown($this->socket, 2);
        socket_close($this->socket);
    }


}