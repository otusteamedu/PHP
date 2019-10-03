<?php
namespace UnixSockets;

class Server
{
    public function __construct(string $a_socketFile) {
        $this->socketFile = $a_socketFile;
        $this->sleep_time = 10000;

        if (file_exists($this->socketFile)) {
            unlink($this->socketFile);
        }
    }

    public function __destruct() {
        socket_shutdown($this->socket);
        socket_close($this->socket);
        if (file_exists($this->socketFile)) {
            unlink($this->socketFile);
        }
    }

    public function listen() {
        $this->socket = $this->connect();

        if (!socket_listen($this->socket)) {
            die('Не удалось прослушивать соединение на сокетем: ' . socket_strerror(socket_last_error()));
        }

        while (true) {
            echo 'Ожидание подключения' . PHP_EOL;

            $this->connection = socket_accept($this->socket);
            echo 'Клиент присоединился! ожидаем запроса.' . PHP_EOL;
            socket_set_nonblock($this->connection);

            while (true) {
                if (($this->line = trim(fgets(STDIN)))  !== false) {
                    socket_write($this->connection, $this->line);
                }

                $response = socket_read($this->connection, 1024);

                if ($response === false || $response === '') {
                    $errno = socket_last_error($this->connection);
                    if ($errno !== 11) {
                        echo "!! Ошибка: {$errno} " . socket_strerror($errno) . PHP_EOL . PHP_EOL;
                        break;
                    }
                }
                else {
                    echo ">> Запрос: ". $response . PHP_EOL;
                    $this->prepareAnswer($response, $this->connection);
                }

                usleep( $this->sleep_time);
            }

            usleep($this->sleep_time);
        }
    }

    public function connect() {
        $stdIn = fopen('php://stdin', 'r');
        stream_set_blocking($stdIn, false);
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);

        if (!socket_bind($socket, $this->socketFile)) {
            die('Не удалось связать сокет с его локальным адресом: ' . socket_strerror(socket_last_error()));
        }

        return $socket;
    }

    public function prepareAnswer($a_message = null) {
        switch ($a_message) {
            case 'hello':
            case 'Hello':
                socket_write($this->connection, $a_message . ' client');
                echo "ответ отправлен >>". PHP_EOL;
                break;

            case 'Bye':
            case 'bye':
                socket_write($this->connection, $a_message . ' client');
                echo "ответ отправлен >>". PHP_EOL;
                break;

            default:
                echo "Ответьте на данный запрос вручную" . PHP_EOL;
                break;
        }
    }
} 