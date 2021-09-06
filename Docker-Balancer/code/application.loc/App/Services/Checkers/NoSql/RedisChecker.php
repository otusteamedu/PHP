<?php

namespace App\Services\Checkers\NoSql;


use App\Exceptions\Connection\InvalidArgumentException;
use App\Helpers\AppConst;
use App\Repository\Redis\RedisReadRepository;
use App\Services\Checkers\AbstractChecker;
use Redis;
use Src\Database\Connectors\ConnectorsFactory;


class RedisChecker extends AbstractChecker
{
    /**
     * @var array
     */
    private array $config;

    /**
     * @var array|string[]
     */
    private array $shortInfoKeys = [
        'redis_version',
        'redis_mode',
        'os',
        'gcc_version',
        'tcp_port',
        'role',
        'cluster_enabled',
    ];


    /**
     * @param array $connectionConfig
     */
    public function __construct(array $connectionConfig = [])
    {
        $this->config = $connectionConfig;
    }

    /**
     * Запускает проверку
     *
     * @return RedisChecker
     * @throws InvalidArgumentException
     */
    public function check(): self
    {
        $info = (new RedisReadRepository($this->connect()))->getInfo();
        $this->info = [
            'status' => AppConst::SERVER_CONNECTED,
            'serverInfo' => $this->layoutInfo($info)
        ];
        $this->shortInfo = [
            'status' => AppConst::SERVER_CONNECTED,
            'serverInfo' => "Redis info: " . $this->layoutShortInfo($info)
        ];
        return $this;
    }

    /**
     * Устанавливает соединение
     *
     * @return Redis
     * @throws InvalidArgumentException
     */
    private function connect(): Redis
    {
        return ConnectorsFactory::createConnection('redis', $this->config)->connect();
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
        foreach ($this->shortInfoKeys as $info) {
            $str .= "<p>" . $info . ": " . $rows[$info] . "</p>";
        }
        return $str;
    }
}