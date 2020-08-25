<?php


namespace App\Socket;


use Exception;

class Socket
{
    const CONFIG_KEY = "socket_path";
    const SOCKET_DOWN = 'down';

    protected $socketPath;
    protected $socket;

    public function __construct($iniFilepath)
    {
        $this->socketPath = $this->getSocketPath($iniFilepath);
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);

        if ($this->socket === false) {
            throw new Exception('Failed to create socket');
        }
    }

    private function getSocketPath($iniFilepath)
    {
        $fileData = parse_ini_file($iniFilepath);
        if (empty($fileData)) {
            throw new Exception('Ini file not be empty');
        }

        return $fileData[self::CONFIG_KEY];
    }

    protected function downSocket()
    {
        socket_shutdown($this->socket, 2);
        socket_close($this->socket);
    }
}