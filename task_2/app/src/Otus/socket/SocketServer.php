<?php


namespace Otus\socket;


class SocketServer extends Socket
{
    public function __construct()
    {
        parent::__construct();

        if (file_exists($this->config['file'])) {
            unlink($this->config['file']);
        }

        if (!socket_bind($this->socket, $this->config['file'])) {
            throw new Exception("Can't bind socket");
        }

        if (!socket_listen($this->socket, 1)) {
            return new Exception("Can't connect socket");
        }
    }

    public function run()
    {
        while (true) {
            $socket = socket_accept($this->socket);

            if (empty($socket)) {
                throw new Exception("Can't accept socket");
            }

            $this->displayCliMessage("New client connected!");

            while (true) {
                $message = trim(socket_read($socket, 1024,PHP_NORMAL_READ));

                $this->displayCliMessage("Received from client: $message");

                if ($message == "close") {
                    $this->displayCliMessage("Server closed");
                    socket_close($socket);
                    break;
                }
            }

        }
    }
}