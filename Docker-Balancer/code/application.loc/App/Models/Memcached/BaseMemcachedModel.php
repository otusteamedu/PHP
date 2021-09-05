<?php

namespace App\Models\Memcached;


use App\Exceptions\Checkers\InvalidCheckerException;
use App\Exceptions\Connection\CannotConnectMemcachedException;
use App\Exceptions\Connection\InvalidArgumentException;
use Exception;
use App\Helpers\ConfigHelper;
use App\Models\BaseModel;
use App\Services\Checkers\AbstractChecker;
use Src\Database\Connectors\ConnectorsFactory;


abstract class BaseMemcachedModel extends BaseModel
{
    const MODEL_NAME = 'memcached';

    /**
     * Информационный заголовок
     * @var string
     */
    protected string $title;
    /**
     * Коннект к базе Memcached
     * @var mixed
     */
    protected mixed $connect;

    /**
     * Название checker-а
     * @var string
     */
    protected string $checkerName;

    /**
     * Информация об ошибке соединения
     * @var array
     */
    protected array $errorConnectInfo;


    /**
     * Конструктор класса
     *
     */
    public function __construct()
    {
        $this->connect(static::MODEL_NAME);
        $this->checkerName = static::MODEL_NAME;
        $this->title = static::MODEL_NAME;
    }

    /**
     * @param string $serverName
     * @return AbstractChecker
     * @throws InvalidCheckerException
     */
    /*public function check(string $serverName): AbstractChecker
    {
        return match ($serverName) {
            'memcached'   => Inspector::check(MemcachedChecker::class, ConfigHelper::getConnectionConfigMemCached()),
            'memcached-1' => Inspector::check(MemcachedChecker::class, ConfigHelper::getConnectionConfigMemCached1()),
            'memcached-2' => Inspector::check(MemcachedChecker::class, ConfigHelper::getConnectionConfigMemCached2()),
        };
    }*/

    /**
     *
     * @param string $key
     * @param string $value
     * @return bool
     */
    public function putValue(string $key, string $value): bool
    {
        return $this->connect->set($key, $value);
    }

    /**
     *
     * @param string $key
     * @return mixed
     */
    public function getValue(string $key): mixed
    {
        return $this->connect->get($key);
    }

    /**
     * Устанавливает соединение с выбранным сервером
     *
     * @param $serverName
     */
    protected function connect($serverName)
    {
        try {
            $this->connect = match ($serverName) {
                'memcached-1' => ConnectorsFactory::createConnection($_ENV['MEMCACHED_DRIVER'], ConfigHelper::getConnectionConfigMemCached1())->connect(),
                'memcached-2' => ConnectorsFactory::createConnection($_ENV['MEMCACHED_DRIVER'], ConfigHelper::getConnectionConfigMemCached2())->connect(),
            };
        } catch (CannotConnectMemcachedException|InvalidArgumentException $ex) {
            $this->errorConnectInfo = ['code' => $ex->getCode(), 'message' => $ex->getMessage()];
            $this->connect = null;
        }
    }

    /**
     * @return array
     */
    public function getErrorConnectInfo(): array
    {
        return $this->errorConnectInfo;
    }

    /**
     * @return mixed
     */
    public function getConnect(): mixed
    {
        return $this->connect;
    }
}