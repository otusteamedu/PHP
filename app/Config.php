<?php

namespace App;

class Config
{
    private $serverSocketPath;
    private $dataLength;

    public function __construct()
    {
        $config = parse_ini_file(__DIR__ . '/config.ini');
        $this->serverSocketPath = __DIR__ . '/../' . $config['serverSocketPath'];
        $this->dataLength = $config['dataLength'];
    }

    public function getServerSocketPath()
    {
        return $this->serverSocketPath;
    }

    public function getDataLength()
    {
        return $this->dataLength;
    }
}
