<?php


namespace Socket;


final class Socket
{

    private String $socket_path;
    private String $socket_port;
    private $socket;

    public function __construct($socket_path = '', $socket_port = '')
    {
        $this->socket_path = $socket_path;
        $this->socket_port = $socket_port;
    }

    public function create()
    {
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);

        if ($this->socket === false) {
            throw new \SocketException\CanNotCreateSocketException();
        }
    }

    public function bind()
    {
        if (file_exists($this->socket_path))
            unlink($this->socket_path);
        if (!socket_bind($this->socket, $this->socket_path)) {
            throw new \SocketException\CanNotBindSocketException();
        }
    }

    public function connect()
    {
        if (!socket_connect($this->socket, $this->socket_path)) {
            throw new \SocketException\CanNotConnectSocketException();
        }
    }

    public static function select(Array &$read, &$write = null, &$except = null, int $tv_sec = 0, int $tv_usec = 10)
    {
        return socket_select($read, $write, $except, $tv_sec, $tv_usec);
    }

    public function accept()
    {
        echo "Принято подключение" . PHP_EOL;
        return socket_accept($this->socket);
    }

    public function listen()
    {
        if (!socket_listen($this->socket)) {
            throw new \SocketException\FailedListenSocketException();
        }
        echo "Слушаю входящие соединения..." . PHP_EOL;
    }

    public function close()
    {
        socket_close($this->socket);
    }

    public static function shutdown($socket)
    {
        socket_shutdown($socket);
    }

    public static function read($socket)
    {
        return @socket_read($socket, 1024);
    }

    public function write($message)
    {
        socket_write($this->socket, $message);
    }

    public function getSocket()
    {
        return $this->socket;
    }

}