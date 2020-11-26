<?php

namespace Otushw;

use Exception;

class Client extends Socket
{
    public function __construct()
    {
        parent::__construct();

        if (!socket_connect($this->socket, $this->pathSocket, $this->portSocket)) {
            return new Exception("Can't connect socket");
        }
    }

    public function run()
    {
        $message = fgets(STDIN);

        socket_write(
            $this->socket,
            $message,
            strlen($message)
        );
    }
}