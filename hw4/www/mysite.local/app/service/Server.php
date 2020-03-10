<?php

namespace App\Service;

class Server extends BaseService
{
    public function run()
    {
        $this->checkRequierments();
        $socket = $this->getSocketByPath($this->config->getServerSocketPath());

        while (true) {
            $this->socketSetBlock($socket);

            echo "Ожидаем сообщений...\n";

            $clientMessage = trim($this->receive($socket));
            echo sprintf("Получено %s\n", $clientMessage);

            if ($clientMessage === 'exit') {
                $message = 'До новых встреч!';
                $this->send($socket, $message, $this->config->getClientSocketPath());
                break;
            }

            $this->socketSetNonblock($socket);

            $message = sprintf('Принято %s! Пишите ещё.', $clientMessage);
            $this->send($socket, $message, $this->config->getClientSocketPath());
        }

        socket_close($socket);
        unlink($this->config->getServerSocketPath());
    }
}