<?php

namespace Socket;

use Exception;

class App
{
    private const SERVER_MODE_NAME = 'server';
    private const CLIENT_MODE_NAME = 'client';

    private const ALLOWED_MODES = [
        self::SERVER_MODE_NAME,
        self::CLIENT_MODE_NAME,
    ];

    private string $_mode;

    public function __construct($mode)
    {
        if (!extension_loaded('sockets')) {
            throw new Exception('The sockets extension is not loaded');
        }

        if (php_sapi_name() !== 'cli') {
            throw new Exception('App only works in command line interface');
        }

        if (!in_array($mode, self::ALLOWED_MODES)) {
            throw new Exception('Incorrect "mode" param');
        }

        $this->_mode = $mode;
    }

    public function run()
    {
        if ($this->_mode === self::SERVER_MODE_NAME) {
            $server = new UnixSocketServer();
            $server->start();
        }

        if ($this->_mode === self::CLIENT_MODE_NAME) {
            $client = new UnixSocketClient();
            $client->start();
        }
    }
}