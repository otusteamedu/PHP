<?php

namespace UnixSockets;

class Client extends Socket
{
    protected function Act()
    {
        $this->sendData($this->config['server_socket_file_path'], strlen($this->message));
        $this-> receiveData();
        socket_close($this->socket);
    }
}
