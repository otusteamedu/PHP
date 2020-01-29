<?php
namespace UnixSockets;

class Server
{
    public function __construct() {
        $ini_array = parse_ini_file("settings.ini");
        $this->socketFile = $ini_array['socketFile'];
        $this->sleep_time = $ini_array['sleep_time'];

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
            die('Socket listen error: ' . socket_strerror(socket_last_error()));
        }

        while (true) {
            echo 'Waiting client connection...' . PHP_EOL;

            $this->connection = socket_accept($this->socket);
            echo 'Connection established. Waiting message...' . PHP_EOL;
            socket_set_nonblock($this->connection);

            while (true) {
                if (($this->line = trim(fgets(STDIN)))  !== false) {
                    socket_write($this->connection, $this->line);
                }

                $response = socket_read($this->connection, 1024);

                if ($response === false || $response === '') {
                    $errno = socket_last_error($this->connection);
                    if ($errno !== 11) {
                        echo "ERROR: {$errno} " . socket_strerror($errno) . PHP_EOL . PHP_EOL;
                        break;
                    }
                }
                else {
                    echo ">> Income: ". $response . PHP_EOL;
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
            die('Socket bind error: ' . socket_strerror(socket_last_error()));
        }

        return $socket;
    }

    public function prepareAnswer($a_message = null) {
        socket_write($this->connection, 'REPLY: ' . $a_message);
        echo "Reply sent.". PHP_EOL;
    }
} 