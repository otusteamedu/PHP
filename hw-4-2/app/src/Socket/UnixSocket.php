<?php

namespace Socket;

use Exception;

/**
 * Class UnixSocket
 *
 * @package Socket
 */
abstract class UnixSocket
{
    /**
     * @var resource|\Socket
     */
    protected $_socket;

    /**
     * @var string
     */
    private string $_configPath = '../config.ini';

    /**
     * @var array
     */
    protected array $_config;

    /**
     * @return mixed
     */
    abstract public function start ();

    /**
     * UnixSocket constructor.
     *
     * @throws Exception
     */
    public function __construct ()
    {
        $socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
        if ($socket === false) {
            throw new Exception('Unable to create AF_UNIX socket');
        }

        $this->_socket = $socket;

        $this->_setConfig();
    }

    /**
     * @param $fileName
     *
     * @return string
     */
    protected function _getSockFilePath ($fileName): string
    {
        return '../' . $fileName;
    }

    /**
     * @param string $fileName
     *
     * @throws Exception
     */
    protected function _bindSock (string $fileName): void
    {
        $sock = $this->_getSockFilePath($fileName);

        $this->_unlinkSock($sock);

        if (!socket_bind($this->_socket, $sock)) {
            throw new Exception("Unable to bind to $sock");
        }
    }

    /**
     * @param string $filePath
     */
    protected function _unlinkSock (string $filePath): void
    {
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    /**
     *
     */
    private function _setConfig (): void
    {
        $this->_config = parse_ini_file($this->_configPath);
    }
}