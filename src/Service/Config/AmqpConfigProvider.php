<?php declare(strict_types=1);

namespace Service\Config;

class AmqpConfigProvider
{
    private string $configFilename;

    private array $amqpConfig;

    public function __construct(string $configFilename)
    {
        $this->configFilename = $configFilename;
        $this->amqpConfig = parse_ini_file($this->configFilename, true, INI_SCANNER_TYPED);
    }

    public function getHost(): string
    {
        return $this->amqpConfig['rabbitmq']['host'];
    }

    public function getPort(): int
    {
        return $this->amqpConfig['rabbitmq']['port'];
    }

    public function getUser(): string
    {
        return $this->amqpConfig['rabbitmq']['user'];
    }

    public function getPassword(): string
    {
        return $this->amqpConfig['rabbitmq']['password'];
    }

    public function getVHost(): string
    {
        return $this->amqpConfig['rabbitmq']['vhost'];
    }
}
