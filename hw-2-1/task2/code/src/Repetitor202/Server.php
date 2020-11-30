<?php


namespace Repetitor202;


class Server
{
    use SocketTrait;

    public function __construct()
    {
        echo 'Server' . PHP_EOL;
        $this->createSocket();
        $this->bindSocket();
    }

    public function listen()
    {
        echo '>> Listening for messages' . PHP_EOL;

        $run = true;
        while($run){
            $buf = '';
            $from = '';

            try {
                $bytes_received = socket_recvfrom($this->socket, $buf, 65536, 0, $from);
                if ($bytes_received == -1) {
                    echo 'An error occured while receiving from the socket';
                } else {
                    echo 'New message: ' . $buf . PHP_EOL;
                }
            } catch (\Exception $e) {
                $run = false;
                $e->getMessage();
            }
        }
    }
}