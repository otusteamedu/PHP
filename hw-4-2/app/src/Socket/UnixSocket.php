<?php

namespace Socket;

use Exception;

abstract class UnixSocket
{
    protected $_socket;

    private string $_configPath = '../config.ini';

    protected array $_config;

    abstract public function start ();

    public function __construct ()
    {
        $socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
        if ($socket === false) {
            throw new Exception('Unable to create AF_UNIX socket');
        }

        $this->_socket = $socket;

        $this->_setConfig();
    }

    protected function _getSockFilePath ($fileName): string
    {
        return '../' . $fileName;
    }

    protected function _bindSock (string $fileName): void
    {
        $sock = $this->_getSockFilePath($fileName);

        $this->_unlinkSock($sock);

        if (!socket_bind($this->_socket, $sock)) {
            throw new Exception("Unable to bind to $sock");
        }
    }

    protected function _unlinkSock (string $filePath): void
    {
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    private function _setConfig (): void
    {
        $this->_config = parse_ini_file($this->_configPath);
    }
}