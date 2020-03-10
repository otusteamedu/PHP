<?php

namespace App;

class Config
{
    /** @var array $options */
    protected $options;

    public function __construct()
    {
        $this->options = parse_ini_file(__DIR__.'/settings.ini');
    }

    public function getOptionByName(string $optionName)
    {
        return $this->options[$optionName];
    }

    public function getServerSocketPath()
    {
        return $this->getOptionByName('server_socket_path');
    }

    public function getClientSocketPath()
    {
        return $this->getOptionByName('client_socket_path');
    }
}