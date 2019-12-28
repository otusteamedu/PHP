<?php

namespace Chat;

class Client
{

    private $socket = null;

    public function __construct(string $socketAddr)
    {

        if (!$this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0)) {
            throw new \Exception('Error while creating socket');
        }

        if (!socket_connect($this->socket, $socketAddr)) {
            throw new \Exception('Error while socket connect');
        }

    }

    public function run()
    {

        $fh = fopen('php://stdin', 'r');

        while (true) {

            $message = fgets($fh);

            if ('exit' == $message) {
                fclose($fh);
                socket_close($this->socket);
                exit;
            }

            if (false === socket_write($this->socket, $message, strlen($message))) {
                throw new \Exception('Error while sending message');
            }

            echo socket_read($this->socket, 1024)."\n\n";

        }
    }
}
