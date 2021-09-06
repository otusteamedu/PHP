<?php

namespace App\Models\Memcached;


use App\Exceptions\Connection\CannotConnectMemcachedException;
use App\Exceptions\Connection\InvalidArgumentException;
use App\Http\Response\Helpers\StatusCodes;
use App\Repository\Memcached\MemcachedReadRepository;
use App\Repository\Memcached\MemcachedWriteRepository;
use App\Helpers\ConfigHelper;
use App\Models\IModel;
use Src\Database\Connectors\ConnectorsFactory;


abstract class BaseMemcachedModel implements IModel
{
    const SERVER_NAME = 'memcached';

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
        $this->connect(static::SERVER_NAME);
        $this->checkerName = static::SERVER_NAME;
        $this->title = static::SERVER_NAME;
    }

    /**
     * Возвращает массив с параметрами, для Response после вставки Value для ключа key
     *
     * @param string $key
     * @param string $value
     * @return array
     */
    public function putValueReply(string $key, string $value): array
    {
        if (!$this->isConnected()) {
            return $this->errorConnectInfo;
        }

        $displayErrors = ini_get('display_errors');
        ini_set("display_errors", '0'); // нужно выключить вывод ошибок на экран, иначе эта ошибка попадет в CheckerResponse

        $result = [
            'code'      => StatusCodes::OK,
            'message'   => 'Response: Memcached->Put',
            'info'      => [
                'method' => 'Put',
                'server' => static::SERVER_NAME,
            ],
        ];
        if (empty($key)) {
            $result['info'] += [
                'status' => 'Mistake',
                'mistake' => ['message' => 'Пустой ключ'],
            ];
        } else {
            $result['info'] += [
                'lastInsertKey'         => $key,
                'key'                   => $key,
                'lastInsertValue'       => $value,
                'putStatus'             => (new MemcachedWriteRepository($this->connect))->set($key, $value),
            ];
        }
        ini_set("display_errors", $displayErrors); // возвращаем вывод ошибок в исходное состояние
        return $result;
    }

    /**
     * Возвращает массив с параметрами, для Response, в которых присутствует значение value для искомого key
     *
     * @param string $key
     * @return array
     */
    public function getValueReply(string $key): array
    {
        if (!$this->isConnected()) {
            return $this->errorConnectInfo;
        }
        $displayErrors = ini_get('display_errors');
        ini_set("display_errors", '0'); // нужно выключить вывод ошибок на экран, иначе эта ошибка попадет в CheckerResponse
        $result = [
            'code'      => StatusCodes::OK,
            'message'   => 'Response: Memcached->Get',
            'info'      => [
                'method'    => 'Get',
                'status'    => 'OK',
                'server'    => static::SERVER_NAME,
                'key'       => $key,
                'value'     => (new MemcachedReadRepository($this->connect))->get($key),
            ]
        ];
        ini_set("display_errors", $displayErrors); // возвращаем вывод ошибок в исходное состояние
        return $result;
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
            $this->errorConnectInfo = ['code' => $ex->getCode(), 'message' => $ex->getMessage(), 'info' => ['server' => static::SERVER_NAME]];
            $this->connect = null;
        }
    }

    /**
     * @return bool
     */
    private function isConnected(): bool
    {
        return !is_null($this->connect);
    }
}