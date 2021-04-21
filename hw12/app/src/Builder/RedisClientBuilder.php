<?php

declare(strict_types=1);

namespace App\Builder;

use Averias\RedisJson\Client\RedisJsonClientInterface;
use Averias\RedisJson\Exception\RedisClientException;
use Averias\RedisJson\Factory\RedisJsonClientFactory;
use InvalidArgumentException;

class RedisClientBuilder
{

    private string $host;
    private int    $port;
    private int    $dbIndex;
    private string $password;

    public function setHost(string $host): self
    {
        $this->host = $host;

        return $this;
    }

    public function setPort(int $port): self
    {
        $this->port = $port;

        return $this;
    }

    public function setDbIndex(int $dbIndex): self
    {
        $this->dbIndex = $dbIndex;

        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return RedisJsonClientInterface
     * @throws RedisClientException
     */
    public function build(): RedisJsonClientInterface
    {
        $redisClient = (new RedisJsonClientFactory())->createClient(
            [
                'host'     => $this->host,
                'port'     => $this->port,
                'database' => $this->dbIndex,
            ]
        );

        if ($this->password and !$redisClient->auth($this->password)) {
            throw new InvalidArgumentException('Ошибка аутентификации');
        }

        return $redisClient;
    }

}