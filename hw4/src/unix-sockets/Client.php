<?php
namespace UnixSockets;
class Client
{
    public function __construct(string $a_socketFile)
    {
        $this->socketFile = $a_socketFile;
        $this->sleep_time = 10000;
    }

    public function connect()
    {
        $stdIn = fopen('php://stdin', 'r');
        stream_set_blocking($stdIn, false);
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        
        socket_set_nonblock($this->socket);

        if (socket_connect($this->socket, $this->socketFile)) {
            echo 'мы подсоединились к серверу, напишите свой вопрос.'  . PHP_EOL;
            $this->connection();
        }
        else {
            echo "Невозможно соединиться с сервером " . $this->socketFile . PHP_EOL;
        }
    }

    public function connection() {
        while (true) {
            $line = trim(fgets(STDIN));

            if ($line !== false) {
                socket_write($this->socket, $line);
            }

            $response = socket_read($this->socket, 1024);

            if ($response === false || $response === '') {
                $errno = socket_last_error($this->socket);

                if ($errno !== 11) {
                    echo "!! Ошибка: {$errno} " . socket_strerror($errno) . PHP_EOL;
                    break;
                }
            }
            else {
                echo "> " . $response . PHP_EOL;
            }

            usleep($this->sleep_time);
        }
    }
} 