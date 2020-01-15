<?php

namespace UnixSockets;

class Server extends Socket
{
    protected function Act()
    {
        while (1) {
            $data = $this->receiveData();
            $buf = PHP_EOL . '# Response-> ' . $data['message'];
            $this->sendData($data['sender'], strlen($buf), $buf);
            echo "Request processed\n";
        }
    }
}
