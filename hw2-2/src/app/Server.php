<?php


namespace app;
use App\SocketConnectionTrait;


class Server
{
    use SocketConnectionTrait;

    public function __construct()
    {
        echo 'server' . PHP_EOL;

        $this->createConnection();
        $this->bindSocket();
    }

    public function listeningSocket()
    {
        echo 'listening ...' . PHP_EOL;
        while (true) { // server never exits
            // receive query
            if (!socket_set_block($this->socket)) {
                throw new \Exception('Unable to set blocking mode for socket');
            }

            $buf = '';
            $from = '';
            echo '------------------' . PHP_EOL;
            // will block to wait client query
            $bytes_received = socket_recvfrom($this->socket, $buf, 65536, 0, $from);
            if ($bytes_received == -1) {
                throw new \Exception('An error occured while receiving from the socket');
            }

            echo $buf . PHP_EOL;
        }
    }
}