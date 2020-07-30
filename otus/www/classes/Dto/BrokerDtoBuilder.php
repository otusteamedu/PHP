<?php

namespace Classes\Dto;

/**
 * @property string $broker
 * @property string $host
 * @property int $port
 * @property string $userName
 * @property string $password
 * @property string $queueRequestName
 * @property string $queueResponseName
 */

class BrokerDtoBuilder
{
    private $errors;

    private $broker;
    private $host;
    private $port;
    private $userName;
    private $password;
    private $queueRequestName;
    private $queueResponseName;


    public function setBroker(string $broker)
    {
        $this->broker = $broker;
        return $this;
    }

    public function setHost(string $host)
    {
        $this->host = $host;
        return $this;
    }

    public function setPort (int $port)
    {
        $this->port = $port;
        return $this;
    }


    public function setUserName (string $userName)
    {
        $this->userName = $userName;
        return $this;
    }

    public function setPassword (string $password)
    {
        $this->password = $password;
        return $this;
    }

    public function setQueueRequestName (string $queueRequestName)
    {
        $this->queueRequestName = $queueRequestName;
        return $this;
    }

    public function setQueueResponseName (string $queueResponseName)
    {
        $this->queueResponseName = $queueResponseName;
        return $this;
    }

    public function build()
    {
        $this->validate();

        if (!empty($this->errors)) {
            throw new \RuntimeException(implode(';', $this->errors));
        }
        return BrokerDto::build($this);
    }

    public function validate()
    {
        if (empty($this->broker)) {
            $this->errors[] = 'Не задан брокер сообщений';
        }

        if (empty($this->host)) {
            $this->errors[] = 'Не задано хост';
        }

        if (empty($this->port)) {
            $this->errors[] = 'Не задан порт';
        }

        if (empty($this->userName)) {
            $this->errors[] = 'Не задан пользователь';
        }

        if (empty($this->password)) {
            $this->errors[] = 'Не задан пароль';
        }
    }

    public function getBroker()
    {
        return $this->broker;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getQueueRequestName()
    {
        return $this->queueRequestName;
    }

    public function getQueueResponseName()
    {
        return $this->queueResponseName;
    }
}
