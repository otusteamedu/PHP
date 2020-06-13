<?php


namespace App\Settings;


class AmqpConfig extends Config
{
    const FILE_AMQP = 'amqp.php';

    public function __construct($configFileName = self::FILE_AMQP)
    {
        parent::__construct($configFileName);
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getPassword()
    {
        return $this->password;
    }

}