<?php

namespace App\Service;

class Client extends BaseService
{
    public function run()
    {
        $this->checkRequierments();
        $socket = $this->getSocketByPath($this->config->getClientSocketPath());

        $this->socketSetBlock($socket);

        echo "Введите сообщение и нажмите Enter. \nДля выхода введите 'exit':\n";
        $stdin = fopen('php://stdin', 'r');
        while (true) {
            $line = fgets($stdin);
            if (trim($line) === 'exit') {
                echo $this->sendAndReceive($socket, $line)."\n";
                break;
            }

            echo $this->sendAndReceive($socket, $line)."\n";
        }

        socket_close($socket);
        unlink($this->config->getClientSocketPath());
    }

    protected function sendAndReceive($socket, string $message)
    {
        $this->send($socket, $message, $this->config->getServerSocketPath());
        $this->socketSetBlock($socket);
        return $this->receive($socket);
    }
}