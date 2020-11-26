<?php

namespace Otushw;

use Exception;

class Server extends Socket
{
    public function __construct()
    {
        parent::__construct();

        if (file_exists($this->pathSocket)) {
            unlink($this->pathSocket);
        }

        if (!socket_bind($this->socket, $this->pathSocket, $this->portSocket)) {
            throw new Exception("Can't bind socket");
        }

        if (!socket_listen($this->socket, 1)) {
            return new Exception("Can't connect socket");
        }
    }

    public function run()
    {
        while (true) {
            $socketAccept = socket_accept($this->socket);
            if (empty($socketAccept)) {
                throw new Exception("Can't accept socket");
            }

            $buf = socket_read($socketAccept, 1024, PHP_NORMAL_READ);
            if ($buf === false) {
                throw new Exception("Can't read socket");
            }
            echo "Received from client: $buf \n";
            if ($buf === 'exit') {
                break;
            }
        }
    }
}
