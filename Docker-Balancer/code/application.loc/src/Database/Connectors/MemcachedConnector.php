<?php

namespace Src\Database\Connectors;

use App\Exceptions\Connection\CannotConnectMemcachedException;
use App\Exceptions\ErrorCodes;
use App\Exceptions\Connection\InvalidArgumentException;
use Src\Database\Traits\HasErrorHandler;
use Memcached;
use Memcache;

class MemcachedConnector extends Connector implements IConnector
{
    use HasErrorHandler;

    const DSN = 'Memcached';


    /**
     * @param string $driver - драйвер для работы с Memcached (может быть Memcached, или Memcache)
     * @param array $config
     */
    public function __construct(
        private string $driver,
        protected array $config,
    )
    {
        parent::__construct();
    }

    /**
     * Устанавливает соединение с базой данных
     *
     * @return mixed
     * @throws CannotConnectMemcachedException
     * @throws InvalidArgumentException
     */
    public function connect(): mixed
    {
        try {
            $displayErrors = ini_get('display_errors');
            ini_set("display_errors", '0'); // нужно выключить вывод ошибок на экран, иначе эта ошибка попадет в CheckerResponse
            if (class_exists($this->driver)) {
                $connection = new $this->driver();
            } else {
                throw new InvalidArgumentException("The driver '" . $this->driver . "' not found", ErrorCodes::getCode(InvalidArgumentException::class));
            }
            $connection->addServer(
                $this->host,
                $this->port
            );
            if ($connection->getVersion()) {
                ini_set("display_errors", $displayErrors); // возвращаем вывод ошибок в исходное состояние
                return $connection;
            } else {
                ini_set("display_errors", $displayErrors); // возвращаем вывод ошибок в исходное состояние
                throw new CannotConnectMemcachedException("Can't get data", ErrorCodes::getCode(CannotConnectMemcachedException::class));
            }
        } catch (ErrorCodes $ex) {
            throw new CannotConnectMemcachedException($ex->getMessage(), $ex->getCode());
        }
    }
}