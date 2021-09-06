<?php

namespace App\Services\Checkers\NoSql;

use App\Exceptions\Connection\InvalidArgumentException;
use App\Helpers\AppConst;
use App\Repository\Memcached\MemcachedReadRepository;
use App\Services\Checkers\AbstractChecker;
use Src\Database\Connectors\ConnectorsFactory;


class MemcachedChecker extends AbstractChecker
{
    /**
     * @var array
     */
    private array $config;

    /**
     * @var array|string[]
     */
    private array $shortInfoKeys = [
        'version',
        'libevent',
        'max_connections',
        'replication',
    ];

    /**
     * @var string|mixed|null
     */
    private ?string $driver;


    /**
     * @param array $connectionConfig
     */
    public function __construct(array $connectionConfig = [])
    {
        $this->config = $connectionConfig;
        $this->driver = $connectionConfig['driver'];
    }

    /**
     * Запускает проверку
     *
     * @return MemcachedChecker
     * @throws InvalidArgumentException
     */
    public function check(): self
    {
        $memcache = $this->connect();
        $info = (new MemcachedReadRepository($this->connect()))->getInfo();
        $this->info = [
            'status' => AppConst::SERVER_CONNECTED,
            'serverInfo' => $this->layoutInfo($info)
        ];
        $this->shortInfo = [
            'status' => AppConst::SERVER_CONNECTED,
            'serverInfo' => $this->config['host'] . " server info: " . $this->layoutShortInfo($info)
        ];
        return $this;
    }

    /**
     * Устанавливает соединение
     *
     * @return Mixed
     * @throws InvalidArgumentException
     */
    private function connect(): Mixed
    {
        return ConnectorsFactory::createConnection($this->driver, $this->config)->connect();
    }

    /**
     * Верстка Блока Info
     *
     * @param array $rows
     * @return string
     */
    private function layoutInfo(array $rows): string
    {
        $str = '';
        foreach ($rows as $row => $value) {
            $str .= "<p>" . $row . ": " . $value . "</p>";
        }
        return $str;
    }

    /**
     * Верстка Блока ShortInfo
     *
     * @param array $rows
     * @return string
     */
    public function layoutShortInfo(array $rows): string
    {
        $str = '';
        foreach ($this->shortInfoKeys as $key) {
            if (isset($rows[$key]))
                $str .= "<p>" . $key . ": " . $rows[$key] . "</p>";
        }
        return $str;
    }
}