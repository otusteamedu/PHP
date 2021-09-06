<?php

namespace Src\Database\Connectors;


use App\Exceptions\Connection\CannotConnectRedisException;
use Redis;
use RedisException;
use Src\Database\Traits\HasErrorHandler;


class RedisConnector extends Connector implements IConnector
{
    use HasErrorHandler;

    const DSN = 'redis';

    private ?float $timeout;
    private ?string $reserved;
    private ?int $retryInterval;
    private ?float $readTimeout;

    /**
     * @param array $config
     */
    public function __construct(
        protected array $config,
    )
    {
        parent::__construct();
        $this->timeout          = (float)$this->config['timeout'] ?? null;
        $this->reserved         = (mb_strtolower($this->config['reserved']) === 'null' or empty($this->config['reserved'])) ? null : $this->config['reserved'];
        $this->retryInterval    = (int)$this->config['retryInterval'] ?? null;
        $this->readTimeout      = (float)$this->config['readTimeout'] ?? null;
    }

    /**
     * Устанавливает соединение с базой данных
     *
     * @return Redis
     * @throws CannotConnectRedisException
     */
    public function connect(): Redis
    {
        try {
            $redis = new Redis();
            $displayErrors = ini_get('display_errors');
            ini_set("display_errors", 0); // нужно выключить вывод ошибок на экран, иначе эта ошибка попадет в CheckerResponse
            $redis->connect(
                $this->host,
                $this->port,
                $this->timeout,
                $this->reserved,
                $this->retryInterval,
                $this->readTimeout
            );
            ini_set("display_errors", $displayErrors); // возвращаем вывод ошибок в исходное состояние
            return $redis;
        } catch (RedisException $ex) {
            throw new CannotConnectRedisException($ex->getMessage(), $ex->getCode());
        }
    }
}