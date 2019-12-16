<?php


namespace App\Services\Socket;

use App\Services\Socket\Entity\ResultFromSocket;

class Socket implements SocketInterface
{
    private const DIR_SOCKET = __DIR__ . DIRECTORY_SEPARATOR . '..' .
    DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'sockets' . DIRECTORY_SEPARATOR;

    private $socket = null;
    private $nameSocket = null;

    public function getDirSockets(): string
    {
        return self::DIR_SOCKET;
    }

    public function createSocket(int $type, string $nameSocket)
    {
        if (!extension_loaded('sockets')) {
            throw new \Exception('The sockets extension is not loaded.');
        }

        if(!is_dir(self::DIR_SOCKET)) {
            mkdir(self::DIR_SOCKET, 0777, true);
        }

        $this->nameSocket = $nameSocket;

        // TODO: подумать над корректным выключением сервера,
        // чтобы другой сервер калькулятор не занял данный сокет или данный сервис не занял чужой
//        if(file_exists(self::DIR_SOCKET . $this->nameSocket)) {
//            unlink(self::DIR_SOCKET . $this->nameSocket);
//        }

        $this->socket = socket_create($type, SOCK_DGRAM, 0);

        if (!is_resource($this->socket)) {
            throw new \Exception('Не удалось создать сокет');
        }

        if (!socket_set_option($this->socket, SOL_SOCKET, SO_REUSEADDR, 1)) {
            echo 'Unable to set option on socket: ' . socket_strerror(socket_last_error($this->socket)) . PHP_EOL;
        }

        if (!socket_bind($this->socket, self::DIR_SOCKET . $nameSocket)) {
            throw new \ErrorException("Unable to bind to $nameSocket: " . socket_strerror(socket_last_error($this->socket)));
        }

        return $this->socket;
    }

    public function closeSocket(): bool
    {
        if (is_resource($this->socket)) {
            socket_close($this->socket);
            unlink(self::DIR_SOCKET . $this->nameSocket);
        }

        return true;
    }

    public function read(): ResultFromSocket
    {
        if (!socket_set_block($this->socket)) {
            throw new \ErrorException('Unable to set blocking mode for socket');
        }

        $buf = '';
        $from = '';
        $bytes_received = socket_recvfrom($this->socket, $buf, 65536, 0, $from);
        if ($bytes_received == -1) {
            throw new \ErrorException('An error occured while receiving from the socket');
        }

        if (!socket_set_nonblock($this->socket)) {
            throw new \ErrorException('Unable to set nonblocking mode for socket');
        }

        return new ResultFromSocket($buf, $from);
    }

    public function write(string $message, string $socketName): void
    {
        $len = strlen($message);
        socket_sendto($this->socket, $message, $len, MSG_EOF, $socketName);

        return;
    }

    public function __destruct()
    {
        $this->closeSocket();
    }
}