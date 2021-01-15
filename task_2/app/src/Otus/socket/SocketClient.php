<?php


namespace Otus\socket;


class SocketClient extends Socket
{
    public function __construct()
    {
        parent::__construct();

        if (!socket_connect($this->socket, $this->config['file'])) {
            return new Exception("Can't connect socket");
        }
    }

    public function run()
    {
        while (true) {

            $message = fgets(STDIN,1024);

            if (!socket_write($this->socket,$message,strlen($message))) {
                $this->displayCliMessage("Server is gone!");
                break;
            }
        }

    }

}