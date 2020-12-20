<?php

namespace Socket;

/**
 * Class SocketRunner
 *
 * @package Socket
 */
class SocketRunner
{
    /**
     *
     */
    public const SERVER_MODE_NAME = 'server';
    /**
     *
     */
    public const CLIENT_MODE_NAME = 'client';
    /**
     *
     */
    public const SERVER_FILE_NAME_KEY = 'server_filename';
    /**
     *
     */
    public const CLIENT_FILE_NAME_KEY = 'client_filename';

    /**
     * @var string
     */
    public string              $mode;
    /**
     * @var SocketRunnerConfig
     */
    private SocketRunnerConfig $config;

    /**
     * SocketRunner constructor.
     *
     * @param $mode
     *
     * @throws \Exception
     */
    public function __construct ($mode)
    {
        $this->mode = $mode;
        SocketRunnerValidator::validate($this);
        $this->config = new SocketRunnerConfig();
    }

    /**
     * @throws \Exception
     */
    public function run (): void
    {
        $serverSocketFile = new SocketFile($this->config->getItem(self::SERVER_FILE_NAME_KEY));

        if ($this->mode === self::CLIENT_MODE_NAME) {
            $clientSocketFile = new SocketFile($this->config->getItem(self::CLIENT_FILE_NAME_KEY));

            SocketClient::run($clientSocketFile, $serverSocketFile);
        }
        else {
            SocketServer::run($serverSocketFile);
        }
    }
}