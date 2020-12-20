<?php

namespace Socket;

use Exception;

/**
 * Class SocketRunnerConfig
 *
 * @package Socket
 */
class SocketRunnerConfig
{
    /**
     * @var array
     */
    private array $config;

    /**
     * SocketRunnerConfig constructor.
     *
     * @throws Exception
     */
    public function __construct ()
    {
        $this->config = SocketRunnerConfigReader::read();
    }

    /**
     * @param string $key
     *
     * @return string
     * @throws Exception
     */
    public function getItem (string $key): string
    {
        if (!isset($this->config[$key])) {
            throw new Exception("Config record '{$this->config[$key]}' is not found");
        }

        return $this->config[$key];
    }
}